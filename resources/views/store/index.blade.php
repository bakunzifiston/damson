@extends('layouts.site')

@section('title', 'Shop')

@php
    $sym = config('app.currency_symbol', '$');
    $storeCartCount = \App\Http\Controllers\Store\CartController::cartCount(request());
@endphp

@section('content')
    {{-- Hero (shop style, DAMSON palette) --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-brand-900 to-brand-950 text-white">
        <div class="absolute inset-y-0 right-0 hidden w-1/2 lg:block">
            <img src="{{ asset('images/african-mushroom.png') }}"
                 alt=""
                 class="h-full w-full object-cover opacity-90"
                 width="1200" height="800">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900 via-brand-900/80 to-transparent"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:py-24 lg:pr-[42%]">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-damson-yellow">DAMSON store</p>
            <h1 class="mt-3 font-display text-3xl font-semibold leading-tight tracking-tight sm:text-4xl lg:text-5xl">Shop our products</h1>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-brand-100 sm:text-base">
                Tubes, spawn, DMMS kits, and more — filter by category and price, add items to your cart, and check out when you are ready.
            </p>
            <p class="mt-6">
                <a href="{{ route('store.cart') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/25 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:border-damson-yellow/50 hover:bg-white/15">
                    View cart
                    @if ($storeCartCount > 0)
                        <span class="rounded-full bg-damson-orange px-2 py-0.5 text-[11px] font-bold leading-none text-white">{{ $storeCartCount > 99 ? '99+' : $storeCartCount }}</span>
                    @endif
                </a>
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <form action="{{ route('store.index') }}" method="get" id="store-filter-form" class="lg:grid lg:grid-cols-[min(280px,100%)_1fr] lg:items-start lg:gap-10 xl:gap-12">
            {{-- Sidebar filters --}}
            <aside class="store-panel sticky top-24 mb-10 p-6 lg:mb-0">
                <h2 class="font-display text-lg font-semibold text-damson-orange">Filter products</h2>

                <div class="mt-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Price range</p>
                    <p class="mt-2 text-sm font-medium text-brand-950" id="store-price-label">
                        {{ $sym }}{{ number_format($minP, 2) }} — {{ $sym }}{{ number_format($maxP, 2) }}
                    </p>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="store-min-price" class="text-xs text-stone-500">Minimum</label>
                            <input type="range" name="min_price" id="store-min-price" class="mt-1 block w-full accent-damson-orange"
                                   min="{{ $floor }}" max="{{ $ceil }}" step="0.01" value="{{ $minP }}">
                        </div>
                        <div>
                            <label for="store-max-price" class="text-xs text-stone-500">Maximum</label>
                            <input type="range" name="max_price" id="store-max-price" class="mt-1 block w-full accent-damson-orange"
                                   min="{{ $floor }}" max="{{ $ceil }}" step="0.01" value="{{ $maxP }}">
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-stone-100 pt-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Category</p>
                    <ul class="mt-3 space-y-2">
                        <li>
                            <label class="flex cursor-pointer items-center justify-between gap-2 rounded-lg px-2 py-1.5 text-sm transition hover:bg-stone-50">
                                <span class="flex items-center gap-2">
                                    <input type="radio" name="category" value="" class="border-stone-300 text-damson-orange focus:ring-damson-orange" @checked($category === '')>
                                    All products
                                </span>
                                <span class="rounded-full bg-damson-orange-muted px-2 py-0.5 text-[11px] font-semibold text-damson-orange">{{ $totalCatalog }}</span>
                            </label>
                        </li>
                        @foreach ($categoryCounts as $cat => $count)
                            <li>
                                <label class="flex cursor-pointer items-center justify-between gap-2 rounded-lg px-2 py-1.5 text-sm transition hover:bg-stone-50">
                                    <span class="flex items-center gap-2">
                                        <input type="radio" name="category" value="{{ $cat }}" class="border-stone-300 text-damson-orange focus:ring-damson-orange" @checked($category === $cat)>
                                        {{ str_replace('_', ' ', $cat) }}
                                    </span>
                                    <span class="rounded-full bg-damson-orange-muted px-2 py-0.5 text-[11px] font-semibold text-damson-orange">{{ $count }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-8 flex flex-col gap-3 border-t border-stone-100 pt-6">
                    <button type="submit" class="damson-btn-accent w-full rounded-xl py-2.5 text-sm font-semibold shadow-md">Apply filters</button>
                    <a href="{{ route('store.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-stone-200 bg-white py-2.5 text-sm font-semibold text-stone-600 transition hover:border-damson-orange/40 hover:text-damson-orange">
                        <span aria-hidden="true">✕</span> Clear all
                    </a>
                </div>
            </aside>

            {{-- Grid --}}
            <div class="min-w-0">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-stone-600">
                        @if ($products->total() === 0)
                            No products match your filters.
                        @else
                            Showing <span class="font-semibold text-brand-950">{{ $products->firstItem() }}</span>–<span class="font-semibold text-brand-950">{{ $products->lastItem() }}</span>
                            of <span class="font-semibold text-brand-950">{{ $products->total() }}</span> results
                        @endif
                    </p>
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <a href="{{ route('store.cart') }}" class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm font-semibold text-brand-950 shadow-sm transition hover:border-damson-orange/40 hover:text-damson-orange">
                            View cart
                            @if ($storeCartCount > 0)
                                <span class="rounded-full bg-damson-orange px-2 py-0.5 text-[11px] font-bold leading-none text-white">{{ $storeCartCount > 99 ? '99+' : $storeCartCount }}</span>
                            @endif
                        </a>
                        <div class="flex items-center gap-2">
                        <label for="store-sort" class="text-xs font-medium uppercase tracking-wide text-stone-500">Sort</label>
                        <select name="sort" id="store-sort" class="rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm text-stone-800 shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                            <option value="default" @selected($sort === 'default')>Default</option>
                            <option value="name" @selected($sort === 'name')>Name A–Z</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                        </select>
                        </div>
                    </div>
                </div>

                <ul class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                    @forelse ($products as $product)
                        <li class="group">
                            <article class="store-card flex h-full flex-col">
                                <div class="relative aspect-square overflow-hidden bg-stone-100">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" width="600" height="600">
                                    @else
                                        <div class="flex h-full items-center justify-center text-sm text-stone-400">No image</div>
                                    @endif
                                    <div class="absolute left-3 top-3 flex gap-2 opacity-0 transition group-hover:opacity-100">
                                        <a href="{{ route('store.show', $product) }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-damson-orange text-white shadow-md ring-2 ring-white/80 transition hover:bg-damson-orange-hover" title="Quick view">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col p-5">
                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-stone-400">{{ str_replace('_', ' ', $product->category) }}</p>
                                    <h2 class="mt-1 font-display text-base font-semibold leading-snug text-brand-950">
                                        <a href="{{ route('store.show', $product) }}" class="hover:text-damson-orange">{{ $product->name }}</a>
                                    </h2>
                                    <p class="mt-2 line-clamp-2 text-xs text-stone-500">{{ Str::limit(strip_tags($product->description), 90) }}</p>
                                    <p class="mt-4 text-lg font-semibold text-damson-orange">
                                        {{ $sym }}{{ number_format((float) $product->price, 2) }}
                                        <span class="text-xs font-normal text-stone-500">/ {{ $product->unit ?? 'unit' }}</span>
                                    </p>
                                    <div class="mt-auto space-y-3 pt-5">
                                        <a href="{{ route('store.show', $product) }}" class="damson-btn-accent block w-full rounded-xl py-2.5 text-center text-sm font-semibold shadow-md">View product</a>
                                        @if ($product->stock > 0)
                                            <form action="{{ route('store.cart.add') }}" method="post" class="flex flex-wrap items-end gap-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <label class="flex min-w-[4.5rem] flex-1 flex-col text-[10px] font-semibold uppercase tracking-wide text-stone-500">
                                                    Qty
                                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required
                                                           class="mt-1 w-full rounded-lg border border-stone-200 px-2 py-1.5 text-sm text-stone-900 shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                                                </label>
                                                <button type="submit" class="rounded-xl border border-brand-900/20 bg-white px-4 py-2 text-sm font-semibold text-brand-950 shadow-sm transition hover:border-damson-orange/40 hover:text-damson-orange">
                                                    Add to cart
                                                </button>
                                            </form>
                                        @else
                                            <p class="text-center text-xs font-medium text-stone-500">Out of stock</p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </li>
                    @empty
                        <li class="col-span-full rounded-2xl border border-dashed border-brand-900/15 bg-white/60 py-16 text-center text-sm text-stone-500">
                            Try widening the price range or choosing <strong class="text-brand-950">All products</strong>.
                        </li>
                    @endforelse
                </ul>

                {{ $products->links('vendor.pagination.store-shop') }}
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('store-filter-form');
            const minEl = document.getElementById('store-min-price');
            const maxEl = document.getElementById('store-max-price');
            const label = document.getElementById('store-price-label');
            const sortEl = document.getElementById('store-sort');
            const sym = @json($sym);

            function fmt(n) {
                return sym + Number(n).toFixed(2);
            }

            function sync() {
                let lo = parseFloat(minEl.value);
                let hi = parseFloat(maxEl.value);
                const minB = parseFloat(minEl.min);
                const maxB = parseFloat(minEl.max);
                if (lo > hi) {
                    if (document.activeElement === minEl) maxEl.value = lo;
                    else minEl.value = hi;
                    lo = parseFloat(minEl.value);
                    hi = parseFloat(maxEl.value);
                }
                lo = Math.max(minB, Math.min(lo, maxB));
                hi = Math.max(minB, Math.min(hi, maxB));
                label.textContent = fmt(lo) + ' — ' + fmt(hi);
            }

            if (minEl && maxEl && label) {
                minEl.addEventListener('input', sync);
                maxEl.addEventListener('input', sync);
                sync();
            }

            if (sortEl && form) {
                sortEl.addEventListener('change', function () {
                    form.submit();
                });
            }
        })();
    </script>
@endpush
