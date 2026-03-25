@extends('layouts.site')

@section('title', $product->name)

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <a href="{{ route('store.index') }}" class="text-sm text-stone-500 hover:text-stone-900">← Store</a>
        <div class="mt-8 grid gap-10 lg:grid-cols-2">
            <div class="aspect-square bg-brand-100/50">
                @if ($product->image_path)
                    <img src="{{ '/storage/'.$product->image_path }}" alt="" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-sm text-stone-400">No image</div>
                @endif
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-stone-400">{{ $product->category }}</p>
                <h1 class="mt-2 font-display text-2xl font-semibold text-stone-900 sm:text-3xl">{{ $product->name }}</h1>
                <p class="mt-1 text-xs text-stone-500">SKU {{ $product->sku }}</p>
                <p class="mt-4 text-xl text-stone-900">{{ config('app.currency_symbol', '$') }}{{ number_format($product->price, 2) }} <span class="text-sm font-normal text-stone-500">/ {{ $product->unit }}</span></p>
                <p class="mt-1 text-sm text-stone-500">Stock {{ number_format($product->stock) }}</p>
                <div class="damson-markdown mt-6 text-sm text-stone-600">
                    {!! Str::markdown($product->description) !!}
                </div>
                @if ($product->stock > 0)
                    <form action="{{ route('store.cart.add') }}" method="post" class="mt-8 flex flex-wrap items-end gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label class="flex flex-col text-xs font-semibold uppercase tracking-wide text-stone-500">
                            Quantity
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required
                                   class="mt-1 w-28 rounded-xl border border-stone-200 px-3 py-2 text-sm text-stone-900 shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                        </label>
                        <button type="submit" class="damson-btn-accent rounded-xl px-6 py-2.5 text-sm font-semibold shadow-md">Add to cart</button>
                    </form>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('store.cart') }}" class="text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">View cart</a>
                        <span class="text-stone-300" aria-hidden="true">|</span>
                        <a href="{{ route('contact') }}?subject=Order%20{{ urlencode($product->name) }}" class="text-sm text-stone-600 hover:text-stone-900">Enquire instead</a>
                    </div>
                @else
                    <p class="mt-8 text-sm font-medium text-stone-600">This item is currently out of stock.</p>
                    <a href="{{ route('contact') }}?subject=Order%20{{ urlencode($product->name) }}" class="damson-btn mt-4 inline-block">Enquire</a>
                @endif
            </div>
        </div>
    </div>
@endsection
