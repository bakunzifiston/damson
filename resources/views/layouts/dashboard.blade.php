<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DAMSON staff dashboard — DMMS and farm data.">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|fraunces:500,600,700&amp;display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-canvas font-sans text-[15px] leading-normal text-stone-800 antialiased">
    <a href="#main" class="skip-link">Skip to content</a>

    <div class="md:flex">
        {{-- Desktop sidebar --}}
        <aside class="hidden w-64 shrink-0 md:sticky md:top-0 md:block md:h-screen">
            @include('partials.dashboard-sidebar')
        </aside>

        {{-- Mobile drawer --}}
        <div id="dashboard-drawer" class="fixed inset-0 z-50 hidden md:hidden" role="dialog" aria-modal="true" aria-label="Navigation">
            <div class="absolute inset-0 bg-stone-900/50" data-drawer-close></div>
            <div class="relative h-full w-72 max-w-[85vw] shadow-xl">
                @include('partials.dashboard-sidebar')
                <button type="button" data-drawer-close class="absolute right-2 top-3 inline-flex h-9 w-9 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                    <span class="sr-only">Close navigation</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            @include('partials.dashboard-topbar')

            <main id="main" class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                @include('partials.flash', ['inset' => true])
                @yield('content')
            </main>
        </div>
    </div>
    @include('partials.matomo')
</body>
</html>
