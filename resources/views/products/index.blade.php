@extends('layouts.site')

@section('title', 'Products')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 sm:py-16">
            <h1 class="font-display text-3xl font-semibold text-stone-900 sm:text-4xl">Products &amp; services</h1>
            <p class="mt-3 max-w-2xl text-sm text-stone-500 sm:text-base">Tubes, spawn, and DMMS.</p>
        </div>
    </div>

    <div class="mx-auto max-w-5xl space-y-20 px-4 py-14 sm:px-6 sm:py-16">
        <section id="tubes" class="scroll-mt-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div class="order-2 lg:order-1">
                    <h2 class="text-xl font-medium text-stone-900 sm:text-2xl">Mushroom tubes</h2>
                    <p class="mt-3 text-sm text-stone-600 leading-relaxed sm:text-base">
                        Gas exchange, clean inoculation, and reliable colonization for oyster, shiitake, and specialty species.
                    </p>
                    <ul class="mt-6 space-y-2 text-sm text-stone-600">
                        <li>Standard and custom lengths</li>
                        <li>Documented moisture targets</li>
                        <li>Usage notes for stacking and harvest</li>
                    </ul>
                    <p class="mt-6"><a href="{{ route('store.index') }}" class="text-sm font-medium text-stone-900 underline decoration-stone-300 underline-offset-4 hover:decoration-stone-900">Store</a></p>
                </div>
                <div class="order-1 lg:order-2 aspect-[4/3] overflow-hidden bg-brand-100/50">
                    <img src="{{ asset('images/african-mushroom.png') }}" alt="" class="h-full w-full object-cover" width="1200" height="900">
                </div>
            </div>
        </section>

        <section id="spawn" class="scroll-mt-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div class="aspect-[4/3] overflow-hidden bg-brand-100/50">
                    <img src="{{ asset('images/african-mushroom.png') }}" alt="" class="h-full w-full object-cover" width="1200" height="900">
                </div>
                <div>
                    <h2 class="text-xl font-medium text-stone-900 sm:text-2xl">Spawn</h2>
                    <p class="mt-3 text-sm text-stone-600 leading-relaxed sm:text-base">
                        Strains with clear generation labels; batches checked before release. Ask for availability and lead times.
                    </p>
                    <p class="mt-4 text-sm text-stone-600">
                        Store refrigerated, avoid temperature shocks, inoculate within the viability window on the label.
                    </p>
                    <p class="mt-6"><a href="{{ route('store.index') }}" class="text-sm font-medium text-stone-900 underline decoration-stone-300 underline-offset-4 hover:decoration-stone-900">Store</a></p>
                </div>
            </div>
        </section>

        <section id="dmms" class="scroll-mt-24 border-t border-brand-900/10 pt-20">
            <div class="grid gap-10 lg:grid-cols-2">
                <div>
                    <h2 class="text-xl font-medium text-stone-900 sm:text-2xl">DMMS</h2>
                    <p class="mt-3 text-sm text-stone-600 leading-relaxed sm:text-base">
                        Sensors in fruiting and incubation spaces on one dashboard: thresholds, alerts, and history.
                    </p>
                    <ul class="mt-6 space-y-2 text-sm text-stone-600">
                        <li>Real-time temperature and RH</li>
                        <li>Alerts (SMS, email, in-app)</li>
                        <li>Trends and exports</li>
                        <li>Multi-site layout</li>
                    </ul>
                </div>
                <div class="flex aspect-video items-center justify-center border border-dashed border-brand-900/20 bg-brand-100/40 px-6 text-center">
                    <p class="text-sm text-stone-500">Video or diagram placeholder — add embed in this template when ready.</p>
                </div>
            </div>
        </section>
    </div>
@endsection
