@extends('layouts.site')

@section('title', 'Stories')

@section('content')
    @php
        $stats = config('damson.stats');
    @endphp

    @include('partials.page-hero', [
        'title' => 'Success Stories',
        'subtitle' => 'Real outcomes from farmers, partners, and communities growing with DAMSON.',
        'eyebrow' => 'Community impact',
        'image' => 'images/african-mushroom.png',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Stories'],
        ],
    ])

    @if ($featuredStory)
        <section class="page-section bg-white">
            <div class="page-shell">
                <article class="overflow-hidden rounded-3xl border border-stone-200 bg-gradient-to-br from-brand-50 to-white shadow-lg lg:grid lg:grid-cols-2" data-reveal>
                    <div class="relative min-h-[240px] bg-brand-900 lg:min-h-full">
                        <img src="{{ damson_asset('images/home-banner-mushroom.png') }}" alt="" class="h-full w-full object-cover opacity-80">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 to-transparent"></div>
                        <span class="absolute left-6 top-6 rounded-full bg-damson-orange px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">Featured story</span>
                    </div>
                    <div class="flex flex-col justify-center p-8 sm:p-10">
                        @if ($featuredStory->headline)
                            <p class="text-xs font-semibold uppercase tracking-wide text-damson-orange">{{ $featuredStory->headline }}</p>
                        @endif
                        <blockquote class="mt-4 text-lg leading-relaxed text-stone-700">&ldquo;{{ $featuredStory->quote }}&rdquo;</blockquote>
                        <footer class="mt-6 text-sm font-semibold text-brand-950">
                            {{ $featuredStory->name }}
                            @if ($featuredStory->location)
                                <span class="block font-normal text-stone-500">{{ $featuredStory->location }}</span>
                            @endif
                        </footer>
                        <a href="#all-stories" class="damson-btn-accent mt-8 inline-flex w-fit rounded-xl px-5 py-2.5 text-sm">Read more stories</a>
                    </div>
                </article>
            </div>
        </section>
    @endif

    <section id="all-stories" class="page-section page-section-alt">
        <div class="page-shell">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between" data-reveal>
                <div>
                    <p class="landing-eyebrow">All stories</p>
                    <h2 class="damson-section-title mt-2">Grower &amp; partner voices</h2>
                </div>
                <div id="story-filters" class="flex flex-wrap gap-2">
                    @foreach (['all' => 'All', 'farmer' => 'Farmer Success', 'training' => 'Training Impact', 'innovation' => 'Innovation', 'community' => 'Community'] as $key => $label)
                        <button type="button" data-story-filter="{{ $key }}" class="rounded-full border px-3 py-1.5 text-xs font-semibold {{ $key === 'all' ? 'is-active' : '' }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($stories as $story)
                    @php
                        $cat = match (true) {
                            str_contains(strtolower($story->headline ?? ''), 'training') => 'training',
                            str_contains(strtolower($story->location ?? ''), 'goma') => 'community',
                            default => 'farmer',
                        };
                    @endphp
                    <article class="landing-card flex flex-col" data-story-category="{{ $cat }}" data-reveal>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-900 text-lg font-semibold text-white">{{ strtoupper(substr($story->name, 0, 1)) }}</div>
                        @if ($story->headline)
                            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-damson-orange">{{ $story->headline }}</p>
                        @endif
                        <blockquote class="mt-2 flex-1 text-sm leading-relaxed text-stone-600">&ldquo;{{ Str::limit($story->quote, 220) }}&rdquo;</blockquote>
                        <footer class="mt-4 border-t border-stone-100 pt-4 text-sm font-semibold text-brand-950">
                            {{ $story->name }}
                            @if ($story->location)
                                <span class="block text-xs font-normal text-stone-500">{{ $story->location }}</span>
                            @endif
                        </footer>
                    </article>
                @empty
                    <p class="col-span-full text-center text-sm text-stone-500">No stories yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="landing-eyebrow">Video</p>
                <h2 class="damson-section-title mt-3">Farmer interviews</h2>
            </div>
            <div class="mx-auto mt-10 max-w-4xl overflow-hidden rounded-3xl border border-stone-200 shadow-lg aspect-video" data-reveal>
                <iframe class="h-full w-full" src="https://www.youtube.com/embed/c4c-ky2IPlQ" title="DAMSON farmer story" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm text-stone-600">Farmers supported</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['training_sessions'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm text-stone-600">Training sessions</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['districts_reached'] }}" data-suffix="+">0</span></p>
                    <p class="mt-2 text-sm text-stone-600">Districts reached</p>
                </div>
                <div class="landing-stat">
                    <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['yield_improved_pct'] }}" data-suffix="%">0</span></p>
                    <p class="mt-2 text-sm text-stone-600">Yield improvement</p>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-brand-900 text-white">
        <div class="page-shell text-center" data-reveal>
            <p class="landing-eyebrow text-damson-yellow">Stay connected</p>
            <h2 class="mt-3 font-display text-3xl font-semibold">Subscribe for success stories &amp; updates</h2>
            <p class="mx-auto mt-3 max-w-lg text-sm text-brand-100/85">Get farmer highlights, training dates, and product news.</p>
            <form id="newsletter-form" class="mx-auto mt-6 flex max-w-md flex-col gap-2 sm:flex-row">
                <input type="email" required placeholder="you@email.com" class="min-w-0 flex-1 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm text-white placeholder:text-white/40 focus:border-damson-orange focus:outline-none">
                <button type="submit" class="damson-btn-accent rounded-xl px-5 py-2.5 text-sm">Subscribe</button>
            </form>
            <p id="newsletter-note" class="mt-3 hidden text-sm text-damson-yellow" role="status"></p>
        </div>
    </section>
@endsection
