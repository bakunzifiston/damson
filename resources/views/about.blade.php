@extends('layouts.site')

@section('title', 'About us')

@section('content')
    <div class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 sm:py-16">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">Our story</p>
            <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">Building a Sustainable Mushroom Ecosystem</h1>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Damson Mushroom Business Limited is a dedicated agribusiness company focused on developing the mushroom industry in Rwanda through production, training, and input supply.
            </p>
        </div>
    </div>

    <div class="mx-auto max-w-5xl space-y-14 px-4 py-12 sm:px-6 sm:py-16">
        <section class="grid gap-10 lg:grid-cols-[1.4fr_1fr]">
            <div>
                <h2 class="font-display text-2xl font-semibold tracking-tight text-brand-950">Who We Are</h2>
                <p class="mt-4 leading-relaxed text-stone-600">
                    We work closely with smallholder farmers, youth entrepreneurs, women groups, cooperatives, and hospitality businesses. Our goal is to create a complete ecosystem where farmers can learn, produce, and access markets easily.
                </p>
                <p class="mt-4 leading-relaxed text-stone-600">
                    Through quality mushrooms, reliable spawn, and practical training, we support a stronger and more sustainable agricultural future for Rwanda.
                </p>
            </div>
            <div class="rounded-2xl border border-stone-200 bg-stone-50 p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Core focus</h3>
                <ul class="mt-5 space-y-3 text-sm text-stone-700">
                    <li><span class="font-semibold text-brand-950">Quality excellence</span> in products and services</li>
                    <li><span class="font-semibold text-brand-950">Empowerment</span> through knowledge and tools</li>
                    <li><span class="font-semibold text-brand-950">Innovation</span> with modern techniques</li>
                    <li><span class="font-semibold text-brand-950">Integrity</span> in every operation</li>
                </ul>
            </div>
        </section>

        <section class="grid gap-6 sm:grid-cols-2">
            <article class="rounded-2xl border border-stone-200 bg-white p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">Vision</h3>
                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    To become Rwanda&rsquo;s leading mushroom agribusiness and a regional hub for mushroom training and innovation.
                </p>
            </article>
            <article class="rounded-2xl border border-stone-200 bg-white p-6">
                <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">Mission</h3>
                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    To improve food security, create employment opportunities, and empower farmers by producing high-quality mushrooms and providing accessible training and inputs.
                </p>
            </article>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-brand-950">Our Core Values</h2>
            <p class="mt-4 leading-relaxed text-stone-600">
                We are guided by quality excellence, empowerment, innovation, and integrity in everything we do.
            </p>
            <ul class="mt-5 space-y-2 text-sm text-stone-700">
                <li>🌟 <strong class="text-brand-950">Quality Excellence:</strong> We deliver the best products and services without compromise.</li>
                <li>🤝 <strong class="text-brand-950">Empowerment:</strong> We equip farmers with knowledge, tools, and opportunities.</li>
                <li>💡 <strong class="text-brand-950">Innovation:</strong> We adopt modern methods to improve productivity.</li>
                <li>🔍 <strong class="text-brand-950">Integrity:</strong> We operate with honesty, transparency, and professionalism.</li>
            </ul>
        </section>
    </div>
@endsection
