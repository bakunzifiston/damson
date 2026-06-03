@extends('layouts.site')

@section('title', 'About us')

@section('content')
    {{-- Page header --}}
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

    {{-- ===== OVERVIEW SECTION ===== --}}
    @include('partials.about.overview')

    {{-- ===== VALUES SECTION ===== --}}
    @include('partials.about.values')

    {{-- ===== MILESTONES SECTION ===== --}}
    @include('partials.about.milestones')

    {{-- ===== BUSINESS AREAS SECTION ===== --}}
    @include('partials.about.business-areas')

    {{-- ===== STATS SECTION ===== --}}
    @include('partials.about.stats', [
        'stats' => $stats,
    ])

    {{-- ===== TEAM SECTION ===== --}}
    @include('partials.about.team')

    {{-- ===== PARTNERS SECTION ===== --}}
    @include('partials.about.partners')
@endsection
