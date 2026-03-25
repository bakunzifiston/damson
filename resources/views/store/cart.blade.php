@extends('layouts.site')

@section('title', 'Cart')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm text-stone-500"><a href="{{ route('store.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Store</a> / Cart</p>
                <h1 class="mt-1 font-display text-2xl font-semibold text-brand-950 sm:text-3xl">Your cart</h1>
            </div>
            @if ($lines !== [])
                <a href="{{ route('store.checkout') }}" class="damson-btn-accent inline-flex justify-center rounded-xl px-6 py-2.5 text-sm font-semibold shadow-md">Checkout</a>
            @endif
        </div>

        @if ($lines === [])
            <div class="store-panel mt-10 p-10 text-center text-sm text-stone-600">
                <p>Your cart is empty.</p>
                <a href="{{ route('store.index') }}" class="mt-4 inline-block text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Continue shopping</a>
            </div>
        @else
            <ul class="mt-10 divide-y divide-stone-100 rounded-2xl border border-stone-200 bg-white shadow-sm">
                @foreach ($lines as $line)
                    @php
                        /** @var \App\Models\Product $product */
                        $product = $line['product'];
                    @endphp
                    <li class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
                        <div class="flex min-w-0 flex-1 gap-4">
                            <a href="{{ route('store.show', $product) }}" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-stone-100 ring-1 ring-stone-200">
                                @if ($product->image_path)
                                    <img src="{{ Storage::disk("public")->url($product->image_path) }}" alt="" class="h-full w-full object-cover" width="80" height="80">
                                @else
                                    <div class="flex h-full items-center justify-center text-[10px] text-stone-400">No image</div>
                                @endif
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('store.show', $product) }}" class="font-display text-base font-semibold text-brand-950 hover:text-damson-orange">{{ $product->name }}</a>
                                <p class="mt-1 text-sm text-stone-600">{{ $sym }}{{ number_format((float) $product->price, 2) }} / {{ $product->unit }}</p>
                                <p class="mt-0.5 text-xs text-stone-500">In stock: {{ number_format($product->stock) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 sm:justify-end">
                            <form action="{{ route('store.cart.update', $product->id) }}" method="post" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="sr-only" for="qty-{{ $product->id }}">Quantity</label>
                                <input id="qty-{{ $product->id }}" type="number" name="quantity" value="{{ $line['quantity'] }}" min="0" max="{{ $product->stock }}"
                                       class="w-20 rounded-lg border border-stone-200 px-2 py-1.5 text-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                                <button type="submit" class="rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 hover:border-damson-orange/40 hover:text-damson-orange">Update</button>
                            </form>
                            <form action="{{ route('store.cart.remove', $product->id) }}" method="post" onsubmit="return confirm('Remove this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800">Remove</button>
                            </form>
                            <p class="w-full text-right text-sm font-semibold text-brand-950 sm:w-28">{{ $sym }}{{ number_format($line['line_total'], 2) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 flex flex-col items-end gap-4 border-t border-stone-200 pt-6">
                <p class="text-lg font-semibold text-brand-950">Subtotal <span class="text-damson-orange">{{ $sym }}{{ number_format($subtotal, 2) }}</span></p>
                <a href="{{ route('store.checkout') }}" class="damson-btn-accent rounded-xl px-8 py-3 text-sm font-semibold shadow-md">Proceed to checkout</a>
            </div>
        @endif
    </div>
@endsection
