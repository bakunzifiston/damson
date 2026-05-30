@extends('layouts.site')

@section('title', 'About us')

@section('content')
    @include('partials.page-hero', [
        'title' => 'Growing Mushrooms, Growing Livelihoods',
        'subtitle' => 'Damson Mushroom Business Limited is a dedicated agribusiness company focused on developing the mushroom industry in Rwanda through production, training, and input supply.',
        'eyebrow' => 'About DAMSON',
        'image' => 'images/home-banner-mushroom.png',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'About'],
        ],
    ])

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16" data-reveal>
                <div class="relative overflow-hidden rounded-3xl shadow-lg">
                    <img src="{{ damson_asset('images/dried-oyster-mushroom.png') }}" alt="DAMSON mushroom products" class="aspect-[4/3] w-full object-contain bg-white p-4">
                </div>
                <div>
                    <p class="landing-eyebrow">Company overview</p>
                    <h2 class="damson-section-title mt-3">Who we are</h2>
                    <p class="damson-prose mt-4">
                        We work closely with smallholder farmers, youth entrepreneurs, women groups, cooperatives, and hospitality businesses. Our goal is to create a complete ecosystem where farmers can learn, produce, and access markets easily.
                    </p>
                    <p class="damson-prose mt-4">
                        Through quality mushrooms, reliable spawn, and practical training, we support a stronger and more sustainable agricultural future for Rwanda.
                    </p>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <article class="landing-card">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Vision</p>
                            <p class="mt-2 text-sm leading-relaxed text-stone-600">To become Rwanda&rsquo;s leading mushroom agribusiness and a regional hub for mushroom training and innovation.</p>
                        </article>
                        <article class="landing-card">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Mission</p>
                            <p class="mt-2 text-sm leading-relaxed text-stone-600">To deliver high-quality mushroom products and innovative farming solutions that empower farmers, improve livelihoods, and promote sustainable agriculture.</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Our core values</p>
                <h2 class="damson-section-title mt-3">What guides our work</h2>
            </div>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                @foreach ([
                    ['icon' => 'award', 'title' => 'Quality Excellence', 'text' => 'We deliver the best products and services without compromise.'],
                    ['icon' => 'handshake', 'title' => 'Empowerment', 'text' => 'We equip farmers with knowledge, tools, and opportunities.'],
                    ['icon' => 'lightbulb', 'title' => 'Innovation', 'text' => 'We adopt modern methods to improve productivity.'],
                    ['icon' => 'target', 'title' => 'Integrity', 'text' => 'We operate with honesty, transparency, and professionalism.'],
                ] as $value)
                    <article class="landing-card text-center">
                        <div class="landing-icon-wrap mx-auto">
                            <x-landing-icon :name="$value['icon']" class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-brand-950">{{ $value['title'] }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $value['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Our journey</p>
                <h2 class="damson-section-title mt-3">Milestones that shaped DAMSON</h2>
            </div>
            <div class="relative mt-14 space-y-8" data-reveal>
                <div class="timeline-line hidden sm:block" aria-hidden="true"></div>
                @foreach ([
                    ['year' => '2010', 'title' => 'Farm foundation', 'text' => 'Started commercial mushroom production with a focus on quality and hygiene.'],
                    ['year' => '2015', 'title' => 'Spawn production scale-up', 'text' => 'Expanded reliable tube and spawn supply for farmers across Rwanda.'],
                    ['year' => '2019', 'title' => 'Training programs launched', 'text' => 'Introduced hands-on farmer training and capacity building.'],
                    ['year' => '2022', 'title' => 'DMMS innovation', 'text' => 'Deployed smart monitoring solutions to protect yields and reduce losses.'],
                    ['year' => 'Today', 'title' => 'Regional growth', 'text' => 'Serving farmers, cooperatives, and partners across multiple districts.'],
                ] as $milestone)
                    <article class="relative rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:ml-auto sm:max-w-md sm:odd:ml-0 sm:odd:mr-auto lg:max-w-lg">
                        <p class="text-sm font-bold text-damson-orange">{{ $milestone['year'] }}</p>
                        <h3 class="mt-1 font-display text-lg font-semibold text-brand-950">{{ $milestone['title'] }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $milestone['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">What we do</p>
                <h2 class="damson-section-title mt-3">Core business areas</h2>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['icon' => 'sprout', 'title' => 'Mushroom Production'],
                    ['icon' => 'flask', 'title' => 'Spawn Production'],
                    ['icon' => 'book', 'title' => 'Training & Capacity Building'],
                    ['icon' => 'cpu', 'title' => 'DMMS Technology'],
                    ['icon' => 'handshake', 'title' => 'Farmer Support'],
                ] as $area)
                    <article class="landing-card flex gap-4" data-reveal>
                        <div class="landing-icon-wrap shrink-0">
                            <x-landing-icon :name="$area['icon']" class="h-6 w-6" />
                        </div>
                        <h3 class="font-display text-lg font-semibold text-brand-950">{{ $area['title'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm font-medium text-stone-600">Farmers Supported</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['training_sessions'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm font-medium text-stone-600">Training Sessions</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['spawn_produced'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm font-medium text-stone-600">Spawn Produced</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['products_delivered'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm font-medium text-stone-600">Products Delivered</p>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Our team</p>
                <h2 class="damson-section-title mt-3">People behind the mission</h2>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['name' => 'Leadership Team', 'role' => 'Farm & Operations', 'initial' => 'L'],
                    ['name' => 'Training Team', 'role' => 'Capacity Building', 'initial' => 'T'],
                    ['name' => 'Technical Team', 'role' => 'DMMS & Quality', 'initial' => 'D'],
                ] as $member)
                    <article class="landing-card text-center" data-reveal>
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-900 text-2xl font-semibold text-white">{{ $member['initial'] }}</div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-brand-950">{{ $member['name'] }}</h3>
                        <p class="text-sm text-stone-500">{{ $member['role'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Partners</p>
                <h2 class="damson-section-title mt-3">Collaborators &amp; supporters</h2>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                @foreach (['Farmer Cooperatives', 'Agribusiness Networks', 'Training Institutions', 'Local Markets'] as $partner)
                    <div class="flex h-24 items-center justify-center rounded-2xl border border-dashed border-brand-300/60 bg-brand-50 px-4 text-center text-sm font-semibold text-brand-800">{{ $partner }}</div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
