@extends('layouts.dashboard')

@section('title', 'Order '.$order->order_number)

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header :title="$order->order_number" :subtitle="'Placed '.$order->created_at->format('F j, Y \a\t g:i a')" :crumbs="[['label' => 'Orders', 'url' => route('data-hub.orders.index')], ['label' => $order->order_number]]">
            <x-slot:actions>
                <x-status-badge :status="$order->status" :label="$order->status_label" />
            </x-slot:actions>
        </x-dash-header>

        <form action="{{ route('data-hub.orders.status', $order) }}" method="post" class="dashboard-card mt-6 flex flex-wrap items-end gap-3 p-4" onsubmit="return this.status.value !== 'cancelled' || confirm('Cancel this order? Its items will be returned to stock.');">
            @csrf
            @method('PATCH')
            <div class="min-w-[12rem]">
                <label for="status" class="damson-label">Update status</label>
                <select id="status" name="status" class="damson-input">
                    @foreach ($statuses as $value)
                        <option value="{{ $value }}" @selected($order->status === $value)>{{ match ($value) {
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            default => ucfirst($value),
                        } }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="damson-btn">Save status</button>
        </form>

        <div class="mt-6 grid gap-6 lg:grid-cols-5">
            <div class="dashboard-card p-6 lg:col-span-2">
                <h2 class="text-sm font-semibold text-stone-900">Customer</h2>
                <p class="mt-3 font-medium text-stone-900">{{ $order->customer_name }}</p>
                <p class="mt-1 text-sm text-stone-600"><a href="mailto:{{ $order->customer_email }}" class="font-medium text-brand-700 underline-offset-2 hover:underline">{{ $order->customer_email }}</a></p>
                @if ($order->customer_phone)
                    <p class="mt-1 text-sm text-stone-600">{{ $order->customer_phone }}</p>
                @endif
                <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Payment method</h3>
                <p class="mt-2 text-sm text-stone-700">{{ $order->payment_method_label }}</p>
                <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Shipping address</h3>
                <p class="mt-2 whitespace-pre-line text-sm text-stone-700">{{ $order->shipping_address }}</p>
                @if ($order->customer_notes)
                    <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Customer notes</h3>
                    <p class="mt-2 whitespace-pre-line text-sm text-stone-700">{{ $order->customer_notes }}</p>
                @endif
            </div>

            <div class="dashboard-card overflow-hidden lg:col-span-3">
                <div class="border-b border-stone-200 px-6 py-4">
                    <h2 class="text-sm font-semibold text-stone-900">Line items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead><tr>
                                <th scope="col">Product</th>
                                <th scope="col">SKU</th>
                                <th scope="col" class="is-right">Qty</th>
                                <th scope="col" class="is-right">Price</th>
                                <th scope="col" class="is-right">Line</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="font-medium text-stone-900">{{ $item->product_name }}</td>
                                    <td class="text-stone-600">{{ $item->sku ?: '—' }}</td>
                                    <td class="is-right tabular-nums text-stone-700">{{ number_format($item->quantity) }}</td>
                                    <td class="is-right tabular-nums text-stone-700">{{ $sym }}{{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td class="is-right tabular-nums font-medium text-brand-950">{{ $sym }}{{ number_format((float) $item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-stone-50">
                                <td colspan="4" class="is-right font-semibold text-stone-700">Total</td>
                                <td class="is-right tabular-nums text-base font-bold text-brand-950">{{ $sym }}{{ number_format((float) $order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
