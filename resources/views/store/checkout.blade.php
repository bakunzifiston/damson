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
            <div>
                <label for="customer_name" class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Full name</label>
                <input id="customer_name" name="customer_name" type="text" required value="{{ old('customer_name') }}"
                       class="mt-1 w-full rounded-xl border border-stone-200 px-3 py-2.5 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
            </div>
            <div>
                <label for="customer_email" class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Email</label>
                <input id="customer_email" name="customer_email" type="email" required value="{{ old('customer_email') }}"
                       class="mt-1 w-full rounded-xl border border-stone-200 px-3 py-2.5 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
            </div>
            <div>
                <label for="customer_phone" class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Phone <span class="font-normal normal-case text-stone-400">(optional)</span></label>
                <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}"
                       class="mt-1 w-full rounded-xl border border-stone-200 px-3 py-2.5 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
            </div>
            <div>
                <label for="shipping_address" class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Shipping address</label>
                <textarea id="shipping_address" name="shipping_address" rows="4" required
                          class="mt-1 w-full rounded-xl border border-stone-200 px-3 py-2.5 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">{{ old('shipping_address') }}</textarea>
            </div>
            <div>
                <label for="customer_notes" class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Order notes <span class="font-normal normal-case text-stone-400">(optional)</span></label>
                <textarea id="customer_notes" name="customer_notes" rows="3"
                          class="mt-1 w-full rounded-xl border border-stone-200 px-3 py-2.5 text-sm shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">{{ old('customer_notes') }}</textarea>
            </div>

            <fieldset>
                <legend class="block text-xs font-semibold uppercase tracking-wide text-stone-500">Payment method</legend>
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
                <button type="submit" class="damson-btn-accent rounded-xl px-8 py-3 text-sm font-semibold shadow-md">Place order</button>
                <a href="{{ route('store.cart') }}" class="inline-flex items-center rounded-xl border border-stone-200 px-6 py-3 text-sm font-semibold text-stone-700 hover:border-damson-orange/40 hover:text-damson-orange">Back to cart</a>
            </div>
        </form>
    </div>
@endsection
