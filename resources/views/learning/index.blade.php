@extends('layouts.site')

@section('title', 'Learning')

@section('content')
    @include('partials.page-hero', [
        'title' => 'Training & Learning',
        'subtitle' => 'Practical skills, business knowledge, and continuous support for mushroom farmers at every level.',
        'eyebrow' => 'Learning hub',
        'image' => 'images/home-banner-mushroom.png',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Learning'],
        ],
    ])

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between" data-reveal>
                <div>
                    <p class="landing-eyebrow">Get started</p>
                    <h2 class="damson-section-title mt-2">Build your mushroom farming skills</h2>
                </div>
                <a href="{{ route('contact') }}?subject=Training%20enrollment" class="damson-btn-accent shrink-0 rounded-xl px-6 py-3">Enroll now</a>
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Categories</p>
                <h2 class="damson-section-title mt-3">Training categories</h2>
            </div>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['icon' => 'sprout', 'title' => 'Beginner Mushroom Farming', 'text' => 'Foundations for first-time growers.'],
                    ['icon' => 'flask', 'title' => 'Advanced Production', 'text' => 'Scale quality and consistency.'],
                    ['icon' => 'package', 'title' => 'Spawn Production', 'text' => 'Tube handling and contamination control.'],
                    ['icon' => 'chart', 'title' => 'Farm Management', 'text' => 'Operations, hygiene, and planning.'],
                    ['icon' => 'target', 'title' => 'Agribusiness & Marketing', 'text' => 'Pricing, sales, and market access.'],
                    ['icon' => 'cpu', 'title' => 'DMMS Technology Training', 'text' => 'Smart monitoring for better yields.'],
                ] as $cat)
                    <article class="landing-card" data-reveal>
                        <div class="landing-icon-wrap">
                            <x-landing-icon :name="$cat['icon']" class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-brand-950">{{ $cat['title'] }}</h3>
                        <p class="mt-2 text-sm text-stone-600">{{ $cat['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Featured courses</p>
                <h2 class="damson-section-title mt-3">Programs &amp; resources</h2>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['title' => 'Blog & insights', 'meta' => 'Articles · All levels', 'route' => route('learning.blog.index'), 'image' => 'images/african-mushroom.png'],
                    ['title' => 'Step-by-step guides', 'meta' => 'Self-paced · Practical', 'route' => route('learning.guides.index'), 'image' => 'images/home-banner-mushroom.png'],
                    ['title' => 'FAQs', 'meta' => 'Quick answers · Support', 'route' => route('learning.faqs'), 'image' => 'images/dried-oyster-mushroom.png'],
                    ['title' => 'Resource library', 'meta' => 'Documents · Downloads', 'route' => route('learning.library'), 'image' => 'images/african-mushroom.png'],
                ] as $course)
                    <article class="landing-product-card overflow-hidden" data-reveal>
                        <div class="aspect-[16/10] overflow-hidden bg-stone-100">
                            <img src="{{ damson_asset($course['image']) }}" alt="" class="h-full w-full object-cover">
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-medium text-stone-500">{{ $course['meta'] }}</p>
                            <h3 class="mt-1 font-display text-lg font-semibold text-brand-950">{{ $course['title'] }}</h3>
                            <a href="{{ $course['route'] }}" class="damson-btn-accent mt-4 block w-full rounded-xl py-2.5 text-center text-sm">Explore</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section page-section-dark">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow text-damson-yellow">Benefits</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-white sm:text-4xl">Why train with DAMSON</h2>
            </div>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['icon' => 'book', 'title' => 'Practical Training'],
                    ['icon' => 'users', 'title' => 'Expert Mentorship'],
                    ['icon' => 'award', 'title' => 'Certification'],
                    ['icon' => 'chart', 'title' => 'Business Guidance'],
                ] as $benefit)
                    <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center" data-reveal>
                        <x-landing-icon :name="$benefit['icon']" class="mx-auto h-8 w-8 text-damson-yellow" />
                        <h3 class="mt-4 font-display font-semibold text-white">{{ $benefit['title'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Process</p>
                <h2 class="damson-section-title mt-3">Your training journey</h2>
            </div>
            <ol class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach (['Register', 'Attend Training', 'Practice', 'Get Support', 'Grow Your Business'] as $i => $step)
                    <li class="landing-card text-center" data-reveal>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-damson-orange text-sm font-bold text-white">{{ $i + 1 }}</span>
                        <p class="mt-3 text-sm font-semibold text-brand-950">{{ $step }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @if ($testimonials->isNotEmpty())
        <section class="page-section page-section-alt">
            <div class="page-shell">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow">Success stories</p>
                    <h2 class="damson-section-title mt-3">What learners say</h2>
                </div>
                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ($testimonials as $t)
                        <blockquote class="landing-card" data-reveal>
                            <p class="text-sm leading-relaxed text-stone-600">&ldquo;{{ Str::limit($t->quote, 160) }}&rdquo;</p>
                            <footer class="mt-4 border-t border-stone-100 pt-4 text-sm font-semibold text-brand-950">{{ $t->name }}</footer>
                        </blockquote>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="relative overflow-hidden py-20">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900 to-brand-950"></div>
        <div class="page-shell relative text-center" data-reveal>
            <h2 class="font-display text-3xl font-semibold text-white sm:text-4xl">Ready to enroll?</h2>
            <p class="mx-auto mt-4 max-w-xl text-brand-100/90">Join upcoming training programs and grow with DAMSON.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}?subject=Training%20enrollment" class="damson-btn-accent rounded-xl px-6 py-3">Contact us to enroll</a>
                <a href="{{ route('learning.guides.index') }}" class="landing-btn-ghost rounded-xl px-6 py-3">Browse guides</a>
            </div>
        </div>
    </section>
@endsection
