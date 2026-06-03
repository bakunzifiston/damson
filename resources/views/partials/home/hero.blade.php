{{-- Hero Section — static banners; /public/ on hosting matches store product image URLs --}}
@php
    $heroSlideFiles = [
        'images/home-banner-mushroom.png',
        'images/african-mushroom.png',
        'images/dried-oyster-mushroom.png',
    ];
    $heroSlides = array_map(
        fn (string $path) => app()->environment('local') ? asset($path) : '/public/'.$path,
        $heroSlideFiles
    );
@endphp

<section class="relative flex min-h-[72vh] items-end overflow-hidden sm:min-h-[76vh] sm:items-center">
    {{-- Slider Background --}}
    <div id="hero-slider" class="absolute inset-0" aria-hidden="true">
        @foreach ($heroSlides as $slideSrc)
            <div class="hero-slide {{ $loop->first ? 'is-active' : '' }} absolute inset-0">
                <img
                    src="{{ $slideSrc }}"
                    alt=""
                    class="h-full w-full scale-105 object-cover"
                    width="2000"
                    height="1333"
                    @if($loop->first) fetchpriority="high" @endif
                    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                >
            </div>
        @endforeach

        {{-- Gradients for readability --}}
        <div class="absolute inset-0 z-[1] bg-gradient-to-t from-black/90 via-black/55 to-black/25"></div>
        <div class="absolute inset-0 z-[1] bg-gradient-to-r from-black/50 via-transparent to-black/20"></div>
    </div>

    {{-- Navigation Dots --}}
    <div class="absolute bottom-20 left-1/2 z-10 flex -translate-x-1/2 gap-2 sm:bottom-24" data-hero-dots role="tablist" aria-label="Banner slides">
        @foreach ($heroSlides as $i => $slideSrc)
            <button
                type="button"
                class="hero-dot {{ $loop->first ? 'is-active' : '' }}"
                data-hero-go="{{ $i }}"
                aria-label="Show slide {{ $i + 1 }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
            ></button>
        @endforeach
    </div>

    {{-- Hero Content --}}
    <div class="relative z-10 mx-auto w-full max-w-7xl px-4 pb-12 pt-24 sm:px-6 sm:pb-16 sm:pt-28 lg:px-8">
        {{-- Main Headline & Description --}}
        <div class="max-w-3xl" data-reveal>
            <p class="landing-eyebrow text-damson-yellow">
                Rwanda&rsquo;s mushroom value chain partner
            </p>
            <h1 class="mt-4 font-display text-2xl font-semibold leading-[1.12] tracking-tight text-white sm:text-3xl lg:text-4xl">
                Welcome to DAMSON MUSHROOM FARM LTD
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-relaxed text-stone-200 sm:text-lg">
                Complete, innovative solutions across the mushroom value chain — from fresh produce and spawn to training and DMMS smart farming technology.
            </p>

            {{-- CTA Buttons --}}
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('store.index') }}" class="damson-btn-accent rounded-xl px-6 py-3">
                    Explore Products
                </a>
                <a href="{{ route('learning.index') }}" class="landing-btn-ghost rounded-xl px-6 py-3">
                    Join Training
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-3 lg:max-w-3xl" data-reveal>
            <div class="landing-glass">
                <p class="text-2xl font-semibold text-white">
                    <span data-count="{{ $stats['years_experience'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">
                    Years of Experience
                </p>
            </div>
            <div class="landing-glass">
                <p class="text-2xl font-semibold text-white">
                    <span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">
                    Farmers Supported
                </p>
            </div>
            <div class="landing-glass">
                <p class="text-2xl font-semibold text-white">
                    <span data-count="{{ $stats['products_delivered'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">
                    Products Delivered
                </p>
            </div>
        </div>
    </div>
</section>
