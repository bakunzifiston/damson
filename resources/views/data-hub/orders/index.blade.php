@extends('layouts.dashboard')

@section('title', 'Orders')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl">
        <div>
            <p class="text-sm font-medium text-stone-500">
                <a href="{{ route('data-hub.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Overview</a>
                <span class="text-stone-300">/</span>
                Orders
            </p>
            <h1 class="mt-1 font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">Store orders</h1>
            <p class="mt-2 max-w-2xl text-sm text-stone-600">Orders placed through the public store. Update status as you pack and ship.</p>
        </div>

        <div class="dashboard-card mt-8 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-sm">
                    <thead class="bg-brand-50/90">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Order</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Customer</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Email</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Date</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Status</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Items</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Total</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-brand-50/40">
                                <td class="whitespace-nowrap px-4 py-2 font-mono text-xs font-semibold text-brand-950">{{ $order->order_number }}</td>
                                <td class="max-w-[10rem] truncate px-4 py-2 font-medium text-stone-900">{{ $order->customer_name }}</td>
                                <td class="max-w-[12rem] truncate px-4 py-2 text-stone-600">{{ $order->customer_email }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-stone-600">{{ $order->created_at->format('M j, Y g:i a') }}</td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <span class="inline-flex rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-900">{{ $order->status_label }}</span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-right text-stone-700">{{ number_format($order->items_count) }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-right font-medium text-stone-900">{{ $sym }}{{ number_format((float) $order->total, 2) }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-right">
                                    <a href="{{ route('data-hub.orders.show', $order) }}" class="text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-16 text-center text-sm text-stone-500">
                                    No store orders yet. When customers check out, they will appear here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="border-t border-stone-100 bg-stone-50/80 px-4 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
