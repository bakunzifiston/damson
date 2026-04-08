<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DAMSON Mushroom Farm Ltd — mushroom tubes, premium spawn, and the DAMSON Mushroom Monitoring System (DMMS).">
    <title>@yield('title', 'Grow smarter') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|fraunces:500,600,700&amp;display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-damson-page text-stone-800 antialiased font-sans text-[15px] leading-normal">
    @include('partials.nav')
    @include('partials.flash')
    <main class="flex-1">
        @yield('content')
    </main>
    @include('partials.footer')
    @include('partials.chat-widget')
    @stack('scripts')
    @include('partials.matomo')
</body>
</html>
