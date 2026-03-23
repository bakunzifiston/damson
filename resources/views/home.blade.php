@extends('layouts.site')

@section('title', 'Home')

@section('content')
    <section class="relative flex min-h-[72vh] flex-col justify-end overflow-hidden sm:min-h-[78vh] sm:justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&amp;fit=crop&amp;w=2000&amp;q=85"
                 alt=""
                 class="h-full w-full scale-105 object-cover"
                 width="2000" height="1333" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/92 via-brand-900/70 to-brand-900/35 sm:bg-gradient-to-r sm:from-brand-950/88 sm:via-brand-900/55 sm:to-brand-800/25"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-6xl px-4 pb-14 pt-24 sm:px-6 sm:pb-20 sm:pt-28 lg:px-8">
            <h1 class="max-w-[18ch] font-display text-[2rem] font-semibold leading-[1.15] tracking-tight text-white drop-shadow-sm sm:max-w-xl sm:text-4xl lg:text-5xl lg:leading-[1.1]">
                Innovating Mushroom Farming:<br class="hidden sm:inline"> <span class="text-damson-yellow">Grow Smarter, Grow Healthy</span>
            </h1>
            <p class="mt-5 max-w-md text-[15px] leading-relaxed text-stone-200 sm:max-w-lg sm:text-base">
                Premium tubes, lab-grade spawn, and DMMS monitoring — built for yield, quality, and peace of mind.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('store.index') }}" class="damson-btn-accent">Shop</a>
                <a href="{{ route('products') }}" class="inline-flex items-center justify-center rounded-lg border-2 border-damson-panel/90 bg-damson-panel/95 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm backdrop-blur-sm transition hover:bg-damson-panel">Products</a>
                <a href="{{ route('contact') }}" class="rounded-lg px-5 py-2.5 text-sm font-medium text-damson-yellow underline decoration-damson-yellow/60 underline-offset-4 transition hover:decoration-damson-yellow">Contact</a>
            </div>
        </div>
    </section>

    <section class="relative z-10 -mt-6 px-4 pb-16 pt-12 sm:px-6 sm:pb-20 sm:pt-14 lg:px-8">
        <div class="store-surface mx-auto max-w-6xl px-6 py-10 sm:px-8 sm:py-12">
            <div>
                <h2 class="damson-section-title">Mission &amp; vision</h2>
                <p class="damson-prose mt-3 max-w-2xl text-base">Why we exist — and the future we&rsquo;re building with growers.</p>
                <div class="mt-8 grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <div class="relative overflow-hidden rounded-2xl border border-brand-900/12 bg-brand-900 p-6 text-brand-100 shadow-sm sm:p-8">
                        <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-damson-orange/15" aria-hidden="true"></div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-yellow">Vision</p>
                        <h3 class="mt-3 font-display text-xl font-semibold text-white sm:text-2xl">Where we&rsquo;re headed</h3>
                        <p class="mt-4 text-sm leading-relaxed text-brand-100/90 sm:text-base">
                            To be a trusted partner for growers everywhere — combining reliable genetics, practical systems, and farm data you can act on.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-brand-900/12 bg-brand-100/50 p-6 shadow-sm sm:p-8">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Mission</p>
                        <h3 class="mt-3 font-display text-xl font-semibold text-brand-950 sm:text-2xl">How we show up every day</h3>
                        <p class="mt-4 damson-prose text-sm sm:text-base">
                            Deliver quality inputs, hands-on education, and DMMS monitoring so farmers can cut losses, improve flushes, and scale with confidence.
                        </p>
                        <p class="mt-6">
                            <a href="{{ route('about') }}" class="text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Our story →</a>
                        </p>
                    </div>
                </div>
            </div>

            @if ($latestProducts->isNotEmpty())
                @php
                    $sym = config('app.currency_symbol', '$');
                @endphp
                <div class="mt-16 border-t border-brand-900/10 pt-16">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-damson-orange">Store</p>
                            <h2 class="damson-section-title mt-2">Latest products</h2>
                            <p class="damson-prose mt-2 max-w-xl text-base text-stone-600">
                                The newest items in our catalog — added most recently.
                            </p>
                        </div>
                        <a href="{{ route('store.index') }}" class="shrink-0 text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Browse full store →</a>
                    </div>
                    <ul class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                        @foreach ($latestProducts as $product)
                            <li>
                                <article class="store-card flex h-full flex-col">
                                    <a href="{{ route('store.show', $product) }}" class="relative block aspect-square overflow-hidden bg-stone-100">
                                        @if ($product->image_path)
                                            <img src="{{ Storage::url($product->image_path) }}" alt="" class="h-full w-full object-cover transition duration-300 hover:scale-[1.03]" width="480" height="480">
                                        @else
                                            <div class="flex h-full items-center justify-center text-sm text-stone-400">No image</div>
                                        @endif
                                    </a>
                                    <div class="flex flex-1 flex-col p-5">
                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-stone-400">{{ str_replace('_', ' ', $product->category) }}</p>
                                        <h3 class="mt-1 font-display text-base font-semibold leading-snug text-brand-950">
                                            <a href="{{ route('store.show', $product) }}" class="hover:text-damson-orange">{{ $product->name }}</a>
                                        </h3>
                                        <p class="mt-3 text-lg font-semibold text-damson-orange">
                                            {{ $sym }}{{ number_format((float) $product->price, 2) }}
                                            <span class="text-xs font-normal text-stone-500">/ {{ $product->unit ?? 'unit' }}</span>
                                        </p>
                                        <a href="{{ route('store.show', $product) }}" class="mt-auto pt-4 text-sm font-semibold text-brand-950 underline decoration-brand-900/20 underline-offset-2 hover:text-damson-orange hover:decoration-damson-orange/40">View details</a>
                                    </div>
                                </article>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-16 border-t border-brand-900/10 pt-16">
                <div class="max-w-2xl">
                <h2 class="damson-section-title">What we offer</h2>
                <p class="damson-prose mt-3 text-base">
                    Hands-on growing experience plus tools that match how mushroom farms actually run.
                </p>
                </div>
                <div class="mt-10 grid gap-5 sm:grid-cols-3">
                <div class="rounded-2xl border border-brand-900/10 bg-brand-100/35 p-6 transition hover:border-damson-orange/30 hover:bg-damson-orange-muted/50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-900 text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-stone-900">Production</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Tubes and spawn with hygiene standards you can trace.</p>
                </div>
                <div class="rounded-2xl border border-brand-900/10 bg-brand-100/35 p-6 transition hover:border-damson-orange/30 hover:bg-damson-orange-muted/50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-900 text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-stone-900">DMMS</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">RH, temperature, and alerts tuned for fruiting rooms.</p>
                </div>
                <div class="rounded-2xl border border-brand-900/10 bg-brand-100/35 p-6 transition hover:border-damson-orange/30 hover:bg-damson-orange-muted/50 sm:col-span-1">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-damson-orange text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-stone-900">Resources</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Guides, FAQs, and a library for your team.</p>
                    <a href="{{ route('learning.index') }}" class="mt-4 inline-block text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Browse learning →</a>
                </div>
                </div>
            </div>
        </div>
    </section>

    @if ($testimonials->isNotEmpty())
        <section class="border-t border-brand-900/10 bg-brand-100/40 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <h2 class="damson-section-title">From growers</h2>
                <div class="mt-10 grid gap-8 md:grid-cols-3">
                    @foreach ($testimonials as $t)
                        <blockquote class="rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm">
                            <p class="text-sm leading-relaxed text-stone-600">&ldquo;{{ Str::limit($t->quote, 140) }}&rdquo;</p>
                            <footer class="mt-4 border-t border-brand-900/10 pt-4 text-sm font-medium text-stone-900">{{ $t->name }}@if ($t->location)<span class="block text-xs font-normal text-stone-500">{{ $t->location }}</span>@endif</footer>
                        </blockquote>
                    @endforeach
                </div>
                <p class="mt-10">
                    <a href="{{ route('success-stories') }}" class="text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">All stories →</a>
                </p>
            </div>
        </section>
    @endif
@endsection
