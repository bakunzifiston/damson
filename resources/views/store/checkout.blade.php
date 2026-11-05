@extends('layouts.site')

@section('title', 'Checkout')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <p class="text-sm text-stone-500"><a href="{{ route('store.cart') }}" class="text-damson-orange hover:text-damson-orange-hover">Cart</a> / Checkout</p>
        <h1 class="mt-1 font-display text-2xl font-semibold text-brand-950 sm:text-3xl">Checkout</h1>
        <p class="mt-2 text-sm text-stone-600">Enter your details and shipping address. Totals are subtotal only (tax or delivery can be added later).</p>

        <div class="store-panel mt-8 p-6">
            <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-stone-500">Order summary</h2>
            <ul class="mt-4 divide-y divide-stone-100 text-sm">
                @foreach ($lines as $line)
                    @php
                        $product = $line['product'];
                    @endphp
                    <li class="flex justify-between gap-4 py-3">
                        <span class="text-stone-800">{{ $product->name }} × {{ $line['quantity'] }}</span>
                        <span class="shrink-0 font-medium text-brand-950">{{ $sym }}{{ number_format($line['line_total'], 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-4 flex justify-between border-t border-stone-100 pt-4 text-base font-semibold text-brand-950">
                Total
                <span class="text-damson-orange">{{ $sym }}{{ number_format($subtotal, 2) }}</span>
            </p>
        </div>

        <form action="{{ route('store.checkout.store') }}" method="post" class="store-panel mt-8 space-y-5 p-6">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="customer_name" label="Full name" required autocomplete="name" />
                <x-field name="customer_email" label="Email" type="email" required autocomplete="email" />
                <x-field name="customer_phone" label="Phone" optional autocomplete="tel" class="sm:col-span-2" />
            </div>
            <x-field name="shipping_address" label="Shipping address" type="textarea" :rows="4" required autocomplete="street-address" />
            <x-field name="customer_notes" label="Order notes" type="textarea" optional />

            <fieldset>
                <legend class="damson-label">Payment method</legend>
                <div class="mt-3 space-y-3">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-damson-orange/40 bg-damson-orange/5 p-4 shadow-sm ring-2 ring-damson-orange/20">
                        <input
                            type="radio"
                            name="payment_method"
                            value="{{ \App\Models\Order::PAYMENT_CASH_ON_DELIVERY }}"
                            class="mt-1 h-4 w-4 border-stone-300 text-damson-orange focus:ring-damson-orange/30"
                            @checked(old('payment_method', \App\Models\Order::PAYMENT_CASH_ON_DELIVERY) === \App\Models\Order::PAYMENT_CASH_ON_DELIVERY)
                            required
                        >
                        <span>
                            <span class="block text-sm font-semibold text-brand-950">Cash on delivery</span>
                            <span class="mt-1 block text-sm text-stone-600">Pay in cash when your order is delivered to your address.</span>
                        </span>
                    </label>
                </div>
                @error('payment_method')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="damson-btn-accent px-8">Place order</button>
                <a href="{{ route('store.cart') }}" class="damson-btn-outline">Back to cart</a>
            </div>
        </form>
    </div>
@endsection
