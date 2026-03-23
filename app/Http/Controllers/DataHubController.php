<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\DmmsMonitoringRecord;
use App\Models\IncubationRecord;
use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataHubController extends Controller
{
    /** @var array<string, array<string, mixed>> */
    private const MODULES = [
        'purchases' => [
            'title' => 'Purchase inquiries',
            'subtitle' => 'Interest in tubes, spawn, and hardware — newest first.',
            'model' => PurchaseRecord::class,
            'columns' => ['created_at', 'name', 'email', 'phone', 'product_interest', 'quantity', 'unit'],
            'order' => 'created_at',
            'add_label' => 'Add record',
            'add_route' => 'forms.purchase',
        ],
        'sales' => [
            'title' => 'Sales',
            'subtitle' => 'Recorded sales and payment status.',
            'model' => SalesRecord::class,
            'columns' => ['created_at', 'customer_name', 'email', 'product_line', 'amount', 'payment_status'],
            'order' => 'created_at',
            'add_label' => 'Add record',
            'add_route' => 'forms.sales',
        ],
        'dmms' => [
            'title' => 'DMMS readings',
            'subtitle' => 'Environmental readings from the monitoring system.',
            'model' => DmmsMonitoringRecord::class,
            'columns' => ['recorded_at', 'farm_name', 'zone', 'temperature_c', 'humidity_pct', 'co2_ppm', 'alert_message'],
            'order' => 'recorded_at',
            'add_label' => 'Add reading',
            'add_route' => 'forms.dmms',
        ],
        'incubation' => [
            'title' => 'Incubation batches',
            'subtitle' => 'Batch tracking and phase notes.',
            'model' => IncubationRecord::class,
            'columns' => ['created_at', 'batch_reference', 'species', 'phase', 'incubation_start', 'expected_fruit'],
            'order' => 'created_at',
            'add_label' => 'Add batch',
            'add_route' => 'forms.incubation',
        ],
        'contacts' => [
            'title' => 'Contact messages',
            'subtitle' => 'Inbound messages from the website contact form or staff entries.',
            'model' => ContactMessage::class,
            'columns' => ['created_at', 'name', 'email', 'phone', 'subject', 'message'],
            'order' => 'created_at',
            'add_label' => 'Add message',
            'add_route' => 'data-hub.contacts.create',
        ],
    ];

    public function overview(): View
    {
        return view('data-hub.overview', [
            'counts' => [
                'purchases' => PurchaseRecord::query()->count(),
                'sales' => SalesRecord::query()->count(),
                'dmms' => DmmsMonitoringRecord::query()->count(),
                'incubation' => IncubationRecord::query()->count(),
                'contacts' => ContactMessage::query()->count(),
            ],
            'productCount' => Product::query()->count(),
            'orderCount' => Order::query()->count(),
        ]);
    }

    public function module(string $module): View
    {
        $config = self::MODULES[$module] ?? null;
        if ($config === null) {
            abort(404);
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = $config['model'];
        $order = $config['order'];

        $rows = $modelClass::query()
            ->latest($order)
            ->paginate(20)
            ->withQueryString();

        return view('data-hub.module', [
            'module' => $module,
            'meta' => $config,
            'rows' => $rows,
        ]);
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
}
