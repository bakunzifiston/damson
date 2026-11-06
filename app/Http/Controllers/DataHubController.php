<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\ContactMessage;
use App\Models\DmmsMonitoringRecord;
use App\Models\IncubationRecord;
use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataHubController extends Controller
{
    use FiltersLists;

    /** Active products at or below this stock level are flagged as low stock. */
    public const LOW_STOCK_THRESHOLD = 5;

    /** @var array<string, array<string, mixed>> */
    private const MODULES = [
        'purchases' => [
            'title' => 'Purchase inquiries',
            'subtitle' => 'Interest in tubes, spawn, and hardware — newest first.',
            'model' => PurchaseRecord::class,
            'columns' => ['created_at', 'name', 'email', 'phone', 'product_interest', 'quantity', 'unit'],
            'search' => ['name', 'email', 'phone', 'product_interest'],
            'order' => 'created_at',
            'add_label' => 'Add record',
            'add_route' => 'forms.purchase',
        ],
        'sales' => [
            'title' => 'Sales',
            'subtitle' => 'Recorded sales and payment status.',
            'model' => SalesRecord::class,
            'columns' => ['created_at', 'customer_name', 'email', 'product_line', 'amount', 'payment_status'],
            'search' => ['customer_name', 'email', 'product_line'],
            'order' => 'created_at',
            'add_label' => 'Add record',
            'add_route' => 'forms.sales',
        ],
        'dmms' => [
            'title' => 'DMMS readings',
            'subtitle' => 'Environmental readings from the monitoring system.',
            'model' => DmmsMonitoringRecord::class,
            'columns' => ['recorded_at', 'farm_name', 'zone', 'temperature_c', 'humidity_pct', 'co2_ppm', 'alert_message'],
            'search' => ['farm_name', 'zone', 'alert_message'],
            'order' => 'recorded_at',
            'add_label' => 'Add reading',
            'add_route' => 'forms.dmms',
        ],
        'incubation' => [
            'title' => 'Incubation batches',
            'subtitle' => 'Batch tracking and phase notes.',
            'model' => IncubationRecord::class,
            'columns' => ['created_at', 'batch_reference', 'species', 'phase', 'incubation_start', 'expected_fruit'],
            'search' => ['batch_reference', 'species', 'phase'],
            'order' => 'created_at',
            'add_label' => 'Add batch',
            'add_route' => 'forms.incubation',
        ],
        'contacts' => [
            'title' => 'Contact messages',
            'subtitle' => 'Inbound messages from the website contact form or staff entries.',
            'model' => ContactMessage::class,
            'columns' => ['created_at', 'name', 'email', 'phone', 'subject', 'message'],
            'search' => ['name', 'email', 'subject', 'message'],
            'order' => 'created_at',
            'add_label' => 'Add message',
            'add_route' => 'data-hub.contacts.create',
        ],
    ];

    public function overview(): View
    {
        // Revenue and open orders exclude cancelled orders.
        $orderStats = Order::query()
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('SUM(CASE WHEN status = ? THEN 0 ELSE total END) as revenue', [Order::STATUS_CANCELLED])
            ->selectRaw('SUM(CASE WHEN status IN (?, ?) THEN 1 ELSE 0 END) as open_orders', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])
            ->first();

        // Orders per day for the last 14 days (zero-filled so the chart has no gaps).
        $start = Carbon::today()->subDays(13);
        $byDay = Order::query()
            ->where('created_at', '>=', $start)
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $series = [];
        for ($i = 0; $i < 14; $i++) {
            $date = $start->copy()->addDays($i);
            $row = $byDay->get($date->toDateString());
            $series[] = [
                'label' => $date->format('M j'),
                'orders' => (int) ($row->orders ?? 0),
                'revenue' => (float) ($row->revenue ?? 0),
            ];
        }

        return view('data-hub.overview', [
            'counts' => [
                'purchases' => PurchaseRecord::query()->count(),
                'sales' => SalesRecord::query()->count(),
                'dmms' => DmmsMonitoringRecord::query()->count(),
                'incubation' => IncubationRecord::query()->count(),
                'contacts' => ContactMessage::query()->count(),
            ],
            'productCount' => Product::query()->count(),
            'trainingTotal' => TrainingApplication::query()->count(),
            'trainingNew' => TrainingApplication::query()->where('status', 'new')->count(),
            'orderCount' => (int) $orderStats->total_orders,
            'revenue' => (float) $orderStats->revenue,
            'openOrders' => (int) $orderStats->open_orders,
            'series' => $series,
            'recentOrders' => Order::query()->latest()->limit(5)->get(),
            'lowStock' => Product::query()->active()
                ->where('stock', '<=', self::LOW_STOCK_THRESHOLD)
                ->orderBy('stock')->orderBy('name')->limit(5)->get(),
            'lowStockCount' => Product::query()->active()->where('stock', '<=', self::LOW_STOCK_THRESHOLD)->count(),
            'lowStockThreshold' => self::LOW_STOCK_THRESHOLD,
            'recentAlerts' => DmmsMonitoringRecord::query()
                ->whereNotNull('alert_message')->where('alert_message', '!=', '')
                ->latest('recorded_at')->limit(5)->get(),
        ]);
    }

    public function module(Request $request, string $module): View
    {
        $config = self::MODULES[$module] ?? abort(404);

        $query = $this->moduleQuery($request, $module);
        [$sort, $dir] = $this->applySort($query, $request, $config['columns'], $config['order']);

        return view('data-hub.module', [
            'module' => $module,
            'meta' => $config,
            'rows' => $query->paginate(20)->withQueryString(),
            'sort' => $sort,
            'dir' => $dir,
        ]);
    }

    /** CSV export of the (filtered) module list. */
    public function export(Request $request, string $module): StreamedResponse
    {
        $config = self::MODULES[$module] ?? abort(404);

        $query = $this->moduleQuery($request, $module);
        $this->applySort($query, $request, $config['columns'], $config['order']);

        $columns = $config['columns'];
        $filename = 'damson-'.$module.'-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($query, $columns): void {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so spreadsheets read accents correctly
            fputcsv($out, $columns);
            foreach ($query->cursor() as $row) {
                fputcsv($out, array_map(fn (string $col) => $this->csvCell(data_get($row, $col)), $columns));
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function createContact(): View
    {
        return view('data-hub.contact-create');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($validated);

        return redirect()
            ->route('data-hub.module', ['module' => 'contacts'])
            ->with('status', 'Message saved to the inbox.');
    }

    private function moduleQuery(Request $request, string $module): \Illuminate\Database\Eloquent\Builder
    {
        $config = self::MODULES[$module];

        /** @var class-string<Model> $modelClass */
        $modelClass = $config['model'];
        $query = $modelClass::query();

        $this->applySearch($query, $request->query('q'), $config['search']);

        if ($module === 'sales' && in_array($request->query('payment_status'), ['pending', 'partial', 'paid'], true)) {
            $query->where('payment_status', $request->query('payment_status'));
        }
        if ($module === 'dmms' && $request->boolean('alerts')) {
            $query->whereNotNull('alert_message')->where('alert_message', '!=', '');
        }

        return $query;
    }

    /** Neutralise spreadsheet formula injection and format dates. */
    private function csvCell(mixed $value): string
    {
        if ($value instanceof \Carbon\CarbonInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        $text = (string) ($value ?? '');
        if ($text !== '' && in_array($text[0], ['=', '+', '-', '@', "\t", "\r"], true) && ! is_numeric($text)) {
            return "'".$text;
        }

        return $text;
    }
}
