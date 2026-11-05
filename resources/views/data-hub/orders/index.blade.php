@extends('layouts.dashboard')

@section('title', 'Orders')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="Store orders" subtitle="Orders placed through the public store. Update status as you pack and ship." :crumbs="[['label' => 'Orders']]" />

        <div class="dashboard-card mt-6 overflow-hidden">
            <x-list-toolbar placeholder="Search order no., name or email…">
                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select id="status" name="status" class="damson-input !mt-0">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="order_number" label="Order" :sort="$sort" :dir="$dir" />
                            <th scope="col">Customer</th>
                            <x-sort-th column="created_at" label="Date" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="status" label="Status" :sort="$sort" :dir="$dir" />
                            <th scope="col" class="is-right">Items</th>
                            <x-sort-th column="total" label="Total" :sort="$sort" :dir="$dir" right />
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="whitespace-nowrap font-mono text-xs font-semibold text-brand-950">{{ $order->order_number }}</td>
                                <td class="max-w-[16rem]">
                                    <p class="truncate font-medium text-stone-900">{{ $order->customer_name }}</p>
                                    <p class="truncate text-xs text-stone-500">{{ $order->customer_email }}</p>
                                </td>
                                <td class="whitespace-nowrap text-stone-600">{{ $order->created_at->format('M j, Y g:i a') }}</td>
                                <td class="whitespace-nowrap"><x-status-badge :status="$order->status" :label="$order->status_label" /></td>
                                <td class="is-right tabular-nums">{{ number_format($order->items_count) }}</td>
                                <td class="is-right whitespace-nowrap font-medium tabular-nums text-stone-900">{{ $sym }}{{ number_format((float) $order->total, 2) }}</td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.orders.show', $order) }}" class="damson-btn-outline damson-btn-sm">View<span class="sr-only"> order {{ $order->order_number }}</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">
                                @if (request()->hasAny(['q', 'status']))
                                    <x-empty-state title="No matching orders" text="Try a different search or reset the filters." />
                                @else
                                    <x-empty-state title="No store orders yet" text="When customers check out, they will appear here." />
                                @endif
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
@endsection
