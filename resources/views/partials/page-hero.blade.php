@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
    'image' => 'images/home-banner-mushroom.png',
    'breadcrumbs' => [],
    'centered' => false,
])

<section class="page-hero relative overflow-hidden bg-brand-950">
    <div class="absolute inset-0">
        <img src="{{ damson_asset($image) }}" alt="" class="h-full w-full object-cover opacity-50" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-900/88 to-brand-800/70"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(229,138,0,0.15),transparent_50%)]"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:py-24 lg:px-8">
        @include('partials.breadcrumbs', ['items' => $breadcrumbs])
        <div class="{{ $centered ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl' }}" data-reveal>
            @if ($eyebrow)
                <p class="landing-eyebrow text-damson-yellow">{{ $eyebrow }}</p>
            @endif
            <h1 class="mt-3 font-display text-3xl font-semibold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-4 text-base leading-relaxed text-brand-100/90 sm:text-lg">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
