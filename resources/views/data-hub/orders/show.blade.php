@extends('layouts.dashboard')

@section('title', 'Order '.$order->order_number)

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl">
        <p class="text-sm font-medium text-stone-500">
            <a href="{{ route('data-hub.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Overview</a>
            <span class="text-stone-300">/</span>
            <a href="{{ route('data-hub.orders.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Orders</a>
            <span class="text-stone-300">/</span>
            <span class="text-stone-600">{{ $order->order_number }}</span>
        </p>
        <div class="mt-4 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h1 class="font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">{{ $order->order_number }}</h1>
                <p class="mt-2 text-sm text-stone-600">Placed {{ $order->created_at->format('F j, Y \a\t g:i a') }}</p>
            </div>
            <form action="{{ route('data-hub.orders.status', $order) }}" method="post" class="flex flex-wrap items-end gap-3 rounded-xl border border-stone-200 bg-stone-50/80 p-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500">Status</label>
                    <select id="status" name="status" class="mt-1 rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
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
                <button type="submit" class="damson-btn-accent rounded-xl px-5 py-2 text-sm font-semibold shadow-sm">Save status</button>
            </form>
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-2">
            <div class="dashboard-card p-6">
                <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-stone-500">Customer</h2>
                <p class="mt-3 font-medium text-brand-950">{{ $order->customer_name }}</p>
                <p class="mt-1 text-sm text-stone-600"><a href="mailto:{{ $order->customer_email }}" class="text-damson-orange hover:underline">{{ $order->customer_email }}</a></p>
                @if ($order->customer_phone)
                    <p class="mt-1 text-sm text-stone-600">{{ $order->customer_phone }}</p>
                @endif
                <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Shipping address</h3>
                <p class="mt-2 whitespace-pre-line text-sm text-stone-700">{{ $order->shipping_address }}</p>
                @if ($order->customer_notes)
                    <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Customer notes</h3>
                    <p class="mt-2 whitespace-pre-line text-sm text-stone-700">{{ $order->customer_notes }}</p>
                @endif
            </div>

            <div class="dashboard-card overflow-hidden p-0">
                <div class="border-b border-stone-100 bg-brand-50/90 px-6 py-4">
                    <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-stone-600">Line items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-100 text-sm">
                        <thead>
                            <tr class="text-left text-[11px] font-semibold uppercase tracking-wide text-stone-500">
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3">SKU</th>
                                <th class="px-6 py-3 text-right">Qty</th>
                                <th class="px-6 py-3 text-right">Price</th>
                                <th class="px-6 py-3 text-right">Line</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-6 py-3 font-medium text-stone-900">{{ $item->product_name }}</td>
                                    <td class="px-6 py-3 text-stone-600">{{ $item->sku ?: '—' }}</td>
                                    <td class="px-6 py-3 text-right text-stone-700">{{ number_format($item->quantity) }}</td>
                                    <td class="px-6 py-3 text-right text-stone-700">{{ $sym }}{{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td class="px-6 py-3 text-right font-medium text-brand-950">{{ $sym }}{{ number_format((float) $item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-stone-50/80">
                                <td colspan="4" class="px-6 py-3 text-right text-sm font-semibold text-stone-700">Total</td>
                                <td class="px-6 py-3 text-right text-base font-bold text-damson-orange">{{ $sym }}{{ number_format((float) $order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
