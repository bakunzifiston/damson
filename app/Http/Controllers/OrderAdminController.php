<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->withCount('items')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('data-hub.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('data-hub.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', Order::STATUSES)],
        ]);

        $new = $data['status'];
        $old = $order->status;

        if ($old !== Order::STATUS_CANCELLED && $new === Order::STATUS_CANCELLED) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::query()->whereKey($item->product_id)->increment('stock', $item->quantity);
                }
            }
        }

        $order->update(['status' => $new]);

        return redirect()
            ->route('data-hub.orders.show', $order)
            ->with('status', 'Order status updated.');
    }
}
