@extends('layouts.site')

@section('title', 'Home')

@section('content')
    <div class="landing-page">
        {{-- ===== HERO SECTION ===== --}}
        @include('partials.home.hero', [
            'stats' => config('damson.stats'),
        ])

        {{-- ===== MISSION & VISION SECTION ===== --}}
        @include('partials.home.mission-vision')

        {{-- ===== FEATURED PRODUCTS SECTION ===== --}}
        @include('partials.home.featured-products', [
            'featuredProducts' => $featuredProducts,
        ])

        {{-- ===== OUR STORY SECTION ===== --}}
        @include('partials.home.our-story', [
            'stats' => config('damson.stats'),
        ])

        {{-- ===== SERVICES SECTION ===== --}}
        @include('partials.home.services')

        {{-- ===== WHY CHOOSE US SECTION ===== --}}
        @include('partials.home.why-us')

        {{-- ===== IMPACT SECTION ===== --}}
        @include('partials.home.impact', [
            'stats' => config('damson.stats'),
        ])

        {{-- ===== TESTIMONIALS SECTION ===== --}}
        @if ($testimonials->isNotEmpty())
            @include('partials.home.testimonials', [
                'testimonials' => $testimonials,
            ])
        @endif

        {{-- ===== CALL-TO-ACTION SECTION ===== --}}
        @include('partials.home.cta')
    </div>

    @include('partials.whatsapp-float')
@endsection
