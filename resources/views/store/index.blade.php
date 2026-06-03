@extends('layouts.site')

@section('title', 'Shop')

@php
    $sym = config('app.currency_symbol', '$');
    $storeCartCount = \App\Http\Controllers\Store\CartController::cartCount(request());
@endphp

@section('content')
    {{-- Page header --}}
    @include('partials.page-hero', [
        'title' => 'Shop our products',
        'subtitle' => 'Tubes, spawn, fresh mushrooms, and more — filter, search, add to cart, and check out when you are ready.',
        'eyebrow' => 'DAMSON store',
        'image' => 'images/african-mushroom.png',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Store'],
        ],
    ])

    {{-- Featured bar and featured products --}}
    <section class="page-section bg-white pb-0">
        <div class="page-shell" data-reveal>
            <a href="{{ route('store.cart') }}" class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-5 py-2.5 text-sm font-semibold text-brand-950 shadow-sm transition hover:border-damson-orange/40 hover:text-damson-orange">
                View cart
                @if ($storeCartCount > 0)
                    <span class="rounded-full bg-damson-orange px-2 py-0.5 text-[11px] font-bold text-white">{{ $storeCartCount > 99 ? '99+' : $storeCartCount }}</span>
                @endif
            </a>
            @include('partials.store.featured-bar', [
                'featuredProducts' => $featuredProducts,
                'sym' => $sym,
            ])
        </div>
    </section>

    {{-- Main store section with filter sidebar and products grid --}}
    <div class="page-shell pb-16 pt-4 sm:pb-20 lg:pb-24">
        <form action="{{ route('store.index') }}" method="get" id="store-filter-form" class="lg:grid lg:grid-cols-[min(280px,100%)_1fr] lg:items-start lg:gap-10 xl:gap-12">
            {{-- Filter sidebar --}}
            @include('partials.store.filter-sidebar', [
                'search' => $search,
                'minP' => $minP,
                'maxP' => $maxP,
                'floor' => $floor,
                'ceil' => $ceil,
                'sym' => $sym,
                'category' => $category,
                'categoryCounts' => $categoryCounts,
                'totalCatalog' => $totalCatalog,
            ])

            {{-- Products grid --}}
            @include('partials.store.products-grid', [
                'products' => $products,
                'sym' => $sym,
                'sort' => $sort,
                'storeCartCount' => $storeCartCount,
            ])
        </form>
    </div>

    {{-- Trust section --}}
    @include('partials.store.trust-section')
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

