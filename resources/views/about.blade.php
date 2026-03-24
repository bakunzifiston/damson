@extends('layouts.site')

@section('title', 'About us')

@section('content')
    <div class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 sm:py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">About DAMSON</p>
            <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">Built for growers who value consistency</h1>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-stone-600 sm:text-base">
                We combine practical mushroom production experience with clean inputs and simple monitoring tools so farms can improve yields with less guesswork.
            </p>
        </div>
    </div>

    <div class="mx-auto max-w-5xl space-y-14 px-4 py-12 sm:px-6 sm:py-16">
        <section class="grid gap-10 lg:grid-cols-[1.4fr_1fr]">
            <div>
                <h2 class="font-display text-2xl font-semibold tracking-tight text-brand-950">Our story</h2>
                <p class="mt-4 leading-relaxed text-stone-600">
                    DAMSON Mushroom Farm Ltd started with one clear goal: give local growers reliable inputs and support they can trust. What began with mushroom tubes expanded into spawn, training, and the <strong class="text-brand-950">DAMSON Mushroom Monitoring System (DMMS)</strong>.
                </p>
                <p class="mt-4 leading-relaxed text-stone-600">
                    Today we partner with both smallholder and commercial farms to reduce contamination risk, improve flush quality, and make daily decisions with better data.
                </p>
            </div>
            <div class="rounded-2xl border border-stone-200 bg-stone-50 p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">What we focus on</h3>
                <ul class="mt-5 space-y-3 text-sm text-stone-700">
                    <li><span class="font-semibold text-brand-950">Quality inputs</span> for stable production cycles</li>
                    <li><span class="font-semibold text-brand-950">Grower training</span> that is practical and clear</li>
                    <li><span class="font-semibold text-brand-950">Simple monitoring</span> with actionable alerts</li>
                </ul>
            </div>
        </section>

        <section class="grid gap-6 sm:grid-cols-2">
            <article class="rounded-2xl border border-stone-200 bg-white p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">Vision</h3>
                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    To be the trusted partner for mushroom growers across the region through reliable genetics, practical systems, and farm data that drives better outcomes.
                </p>
            </article>
            <article class="rounded-2xl border border-stone-200 bg-white p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">Mission</h3>
                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    Deliver quality inputs, hands-on education, and DMMS tools so farmers can cut losses, increase consistency, and scale sustainably.
                </p>
            </article>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-brand-950">Our team</h2>
            <p class="mt-4 leading-relaxed text-stone-600">
                Our team blends agronomy, mycology, and software engineering. Agronomists manage spawn and substrate quality, field technicians support farm setup and calibration, and product specialists improve DMMS based on direct grower feedback.
            </p>
            <p class="mt-4 leading-relaxed text-stone-600">
                Every improvement is tested in real growing conditions, so our recommendations are practical for day-to-day farm operations.
            </p>
        </section>
    </div>
@endsection
