@extends('layouts.site')

@section('title', 'Order placed')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-16 text-center sm:px-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-damson-orange">Thank you</p>
        <h1 class="mt-3 font-display text-2xl font-semibold text-brand-950 sm:text-3xl">Your order is confirmed</h1>
        <p class="mt-3 text-sm text-stone-600">We received your order and will follow up by email. Save your order number for reference.</p>

        <div class="dashboard-card mx-auto mt-10 max-w-md p-8 text-left">
            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Order number</p>
            <p class="mt-1 font-mono text-lg font-bold text-brand-950">{{ $order->order_number }}</p>
            <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Total</p>
            <p class="mt-1 text-xl font-semibold text-damson-orange">{{ $sym }}{{ number_format((float) $order->total, 2) }}</p>
            <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-stone-500">Shipping to</p>
            <p class="mt-1 text-sm text-stone-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
        </div>

        <a href="{{ route('store.index') }}" class="damson-btn-accent mt-10 inline-block rounded-xl px-8 py-3 text-sm font-semibold shadow-md">Continue shopping</a>
    </div>
@endsection
