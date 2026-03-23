@extends('layouts.site')

@section('title', 'About us')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-3xl px-4 py-14 sm:px-6 sm:py-16">
            <h1 class="font-display text-3xl font-semibold text-stone-900 sm:text-4xl">About</h1>
            <p class="mt-3 text-sm text-stone-500 leading-relaxed sm:text-base">Quality, sustainability, and technology for mushroom growers.</p>
        </div>
    </div>

    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
        <section>
            <h2 class="text-lg font-medium text-stone-900">Our story</h2>
            <p class="mt-4 text-stone-600 leading-relaxed">
                DAMSON Mushroom Farm Ltd began with a simple belief: smallholder and commercial growers deserve the same rigor in substrate, spawn, and environmental control as the world’s best indoor farms. What started as local production of mushroom tubes has grown into an integrated service — spanning spawn, technical training, and the <strong class="text-stone-800">DAMSON Mushroom Monitoring System (DMMS)</strong>.
            </p>
            <p class="mt-4 text-stone-600 leading-relaxed">
                Today we partner with farmers who want predictable flushes, lower contamination risk, and data they can trust. Every product and software release is tested against real growing rooms — not slide decks.
            </p>
        </section>

        <section class="mt-12 grid gap-8 sm:grid-cols-2">
            <div>
                <h3 class="text-sm font-medium text-stone-900">Vision</h3>
                <p class="mt-2 text-sm text-stone-600 leading-relaxed">Trusted partner for growers — reliable genetics, systems, and farm data.</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-stone-900">Mission</h3>
                <p class="mt-2 text-sm text-stone-600 leading-relaxed">Quality inputs, education, and DMMS so farmers can reduce losses and scale.</p>
            </div>
        </section>

        <section class="mt-16">
            <h2 class="text-lg font-medium text-stone-900">Team</h2>
            <p class="mt-4 text-stone-600 leading-relaxed">
                Our core team blends agronomy, mycology, and software engineering. Agronomists oversee spawn and tube batches; field technicians support DMMS rollouts; and our product team ships features based on grower feedback — from alert thresholds to incubation workflows.
            </p>
            <ul class="mt-6 space-y-3 text-sm text-stone-600">
                <li><span class="text-stone-900">Agronomy</span> — spawn &amp; substrate</li>
                <li><span class="text-stone-900">Mycology lab</span> — culture QC</li>
                <li><span class="text-stone-900">Technology</span> — DMMS</li>
            </ul>
        </section>
    </div>
@endsection
