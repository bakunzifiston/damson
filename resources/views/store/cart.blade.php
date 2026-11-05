@extends('layouts.site')

@section('title', 'Cart')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
        <nav aria-label="Breadcrumb" class="text-sm text-stone-500">
            <a href="{{ route('store.index') }}" class="transition hover:text-brand-900">Store</a>
            <span class="mx-1.5 text-stone-300" aria-hidden="true">/</span>
            <span class="text-stone-700" aria-current="page">Cart</span>
        </nav>
        <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-brand-950">Your cart</h1>

        @if ($lines === [])
            <div class="dashboard-card mt-8">
                <x-empty-state title="Your cart is empty" text="Browse the store to find mushrooms, spawn and more.">
                    <a href="{{ route('store.index') }}" class="damson-btn">Continue shopping</a>
                </x-empty-state>
            </div>
        @else
            <div class="mt-8 grid gap-8 lg:grid-cols-3">
                <ul class="dashboard-card divide-y divide-stone-100 lg:col-span-2">
                    @foreach ($lines as $line)
                        @php
                            /** @var \App\Models\Product $product */
                            $product = $line['product'];
                        @endphp
                        <li class="flex gap-4 p-4 sm:p-5">
                            <a href="{{ route('store.show', $product) }}" class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-stone-100 ring-1 ring-stone-200 sm:h-24 sm:w-24">
                                @if ($product->image_path)
                                    <img src="{{ $product->image_url }}" alt="" class="h-full w-full object-cover" width="96" height="96" loading="lazy">
                                @else
                                    <div class="flex h-full items-center justify-center text-[11px] text-stone-400">No image</div>
                                @endif
                            </a>
                            <div class="flex min-w-0 flex-1 flex-col gap-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <a href="{{ route('store.show', $product) }}" class="font-display text-base font-semibold text-brand-950 transition hover:text-damson-orange">{{ $product->name }}</a>
                                        <p class="mt-0.5 text-sm text-stone-600">{{ $sym }}{{ number_format((float) $product->price, 2) }} / {{ $product->unit }}</p>
                                        <p class="text-xs text-stone-500">{{ number_format($product->stock) }} in stock</p>
                                    </div>
                                    <p class="shrink-0 text-base font-semibold tabular-nums text-brand-950">{{ $sym }}{{ number_format($line['line_total'], 2) }}</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                                    <form action="{{ route('store.cart.update', $product->id) }}" method="post" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="sr-only" for="qty-{{ $product->id }}">Quantity for {{ $product->name }}</label>
                                        <input id="qty-{{ $product->id }}" type="number" name="quantity" value="{{ $line['quantity'] }}" min="0" max="{{ $product->stock }}" class="damson-input !mt-0 !w-20 !py-1.5">
                                        <button type="submit" class="damson-btn-outline damson-btn-sm">Update</button>
                                    </form>
                                    <form action="{{ route('store.cart.remove', $product->id) }}" method="post" onsubmit="return confirm('Remove this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 underline-offset-2 hover:text-red-800 hover:underline">Remove<span class="sr-only"> {{ $product->name }}</span></button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <aside class="lg:col-span-1" aria-label="Order summary">
                    <div class="dashboard-card p-6 lg:sticky lg:top-24">
                        <h2 class="text-sm font-semibold text-stone-900">Order summary</h2>
                        <dl class="mt-4 flex items-baseline justify-between border-t border-stone-100 pt-4">
                            <dt class="text-sm text-stone-600">Subtotal</dt>
                            <dd class="text-xl font-semibold tabular-nums text-brand-950">{{ $sym }}{{ number_format($subtotal, 2) }}</dd>
                        </dl>
                        <a href="{{ route('store.checkout') }}" class="damson-btn-accent mt-5 w-full">Proceed to checkout</a>
                        <a href="{{ route('store.index') }}" class="mt-3 block text-center text-sm font-medium text-stone-600 hover:text-brand-900">Continue shopping</a>
                    </div>
                </aside>
            </div>
        @endif
    </div>
@endsection
