<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    use FiltersLists;

    public function index(Request $request): View
    {
        $query = Order::query()->withCount('items');

        $this->applySearch($query, $request->query('q'), ['order_number', 'customer_name', 'customer_email']);
        if (in_array($request->query('status'), Order::STATUSES, true)) {
            $query->where('status', $request->query('status'));
        }
        [$sort, $dir] = $this->applySort($query, $request, ['created_at', 'total', 'status', 'order_number'], 'created_at');

        return view('data-hub.orders.index', [
            'orders' => $query->paginate(20)->withQueryString(),
            'statuses' => Order::STATUSES,
            'sort' => $sort,
            'dir' => $dir,
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('data-hub.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    /**
     * Change status. Stock is returned when an order is cancelled and re-reserved
     * if a cancelled order is re-opened, so inventory always matches open orders.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', Order::STATUSES)],
        ]);

        $new = $data['status'];

        try {
            DB::transaction(function () use ($order, $new): void {
                $locked = Order::query()->whereKey($order->id)->lockForUpdate()->firstOrFail();
                $old = $locked->status;
                $items = $locked->items()->get();

                if ($old !== Order::STATUS_CANCELLED && $new === Order::STATUS_CANCELLED) {
                    foreach ($items as $item) {
                        if ($item->product_id) {
                            Product::query()->whereKey($item->product_id)->increment('stock', $item->quantity);
                        }
                    }
                } elseif ($old === Order::STATUS_CANCELLED && $new !== Order::STATUS_CANCELLED) {
                    foreach ($items as $item) {
                        if (! $item->product_id) {
                            continue;
                        }
                        $product = Product::query()->whereKey($item->product_id)->lockForUpdate()->first();
                        if ($product && $product->stock < $item->quantity) {
                            throw new \RuntimeException("Cannot re-open: only {$product->stock} of {$product->name} left in stock (order needs {$item->quantity}).");
                        }
                        $product?->decrement('stock', $item->quantity);
                    }
                }

                $locked->update(['status' => $new]);
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('data-hub.orders.show', $order)->withErrors(['status' => $e->getMessage()]);
        }

        return redirect()
            ->route('data-hub.orders.show', $order)
            ->with('status', 'Order status updated.');
    }
}
