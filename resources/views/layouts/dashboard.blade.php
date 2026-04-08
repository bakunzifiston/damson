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
<body class="dashboard-canvas text-stone-800 antialiased font-sans text-[15px] leading-normal">
    <div class="flex min-h-screen">
        @include('partials.dashboard-sidebar')

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            @include('partials.dashboard-topbar')

            <div class="px-4 sm:px-6 lg:px-8">
                @include('partials.flash')
            </div>

            <main class="flex-1 px-4 pb-10 pt-2 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>
    @include('partials.matomo')
</body>
</html>
