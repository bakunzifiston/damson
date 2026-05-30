@php
    $moduleActive = fn (string $key) => request()->routeIs('data-hub.module') && request()->route('module') === $key;
    $link = fn (bool $active) => $active
        ? 'border-l-4 border-damson-orange bg-white/10 text-white'
        : 'border-l-4 border-transparent text-brand-200 hover:bg-white/5 hover:text-white';
@endphp

<aside class="relative hidden w-64 shrink-0 flex-col bg-brand-950 text-brand-100 shadow-[4px_0_24px_-8px_rgba(0,40,27,0.35)] md:flex">
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-damson-orange/20 via-brand-950/80 to-transparent" aria-hidden="true"></div>

    <div class="relative flex items-center gap-3 border-b border-white/10 px-5 py-6">
        <img src="{{ asset('images/logo.png') }}" alt="" width="44" height="44" class="h-11 w-11 rounded-full object-cover ring-2 ring-white/20" role="presentation">
        <div>
            <p class="font-display text-lg font-semibold tracking-tight text-white">DAMSON</p>
            <p class="text-[10px] font-medium uppercase tracking-[0.15em] text-damson-yellow/90">Staff</p>
        </div>
    </div>

    <nav class="relative flex flex-1 flex-col gap-6 overflow-y-auto px-3 py-5" aria-label="Dashboard">
        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Overview</p>
            <a href="{{ route('data-hub.index') }}"
               class="mt-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link(request()->routeIs('data-hub.index')) }}">
                <svg class="h-5 w-5 shrink-0 text-damson-yellow/90" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
        </div>

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Records</p>
            <ul class="mt-2 space-y-0.5">
                <li>
                    <a href="{{ route('data-hub.products.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link(request()->routeIs('data-hub.products.*')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.orders.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link(request()->routeIs('data-hub.orders.*')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.module', ['module' => 'purchases']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link($moduleActive('purchases')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Purchases
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.module', ['module' => 'sales']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link($moduleActive('sales')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Sales
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.module', ['module' => 'dmms']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link($moduleActive('dmms')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        DMMS
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.module', ['module' => 'incubation']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link($moduleActive('incubation')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Incubation
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-hub.module', ['module' => 'contacts']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $link($moduleActive('contacts') || request()->routeIs('data-hub.contacts.create')) }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Messages
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Shortcuts</p>
            <ul class="mt-2 space-y-0.5">
                <li>
                    <a href="{{ route('forms.hub') }}" class="flex items-center gap-3 rounded-xl border-l-4 border-transparent px-3 py-2.5 text-sm font-medium text-brand-200 transition hover:bg-white/5 hover:text-white">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Forms hub
                    </a>
                </li>
                <li>
                    <a href="{{ route('store.index') }}" class="flex items-center gap-3 rounded-xl border-l-4 border-transparent px-3 py-2.5 text-sm font-medium text-brand-200 transition hover:bg-white/5 hover:text-white">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Store
                    </a>
                </li>
                <li>
                    <a href="{{ route('learning.index') }}" class="flex items-center gap-3 rounded-xl border-l-4 border-transparent px-3 py-2.5 text-sm font-medium text-brand-200 transition hover:bg-white/5 hover:text-white">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Learning
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl border-l-4 border-transparent px-3 py-2.5 text-sm font-medium text-brand-200 transition hover:bg-white/5 hover:text-white">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Website
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="relative border-t border-white/10 p-4">
        <p class="truncate text-xs font-medium text-white">{{ auth()->user()->name }}</p>
        <p class="truncate text-[11px] text-brand-200">{{ auth()->user()->email }}</p>
        <form action="{{ route('logout') }}" method="post" class="mt-3">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-white/15 bg-white/5 py-2 text-xs font-semibold text-brand-100 transition hover:border-damson-orange/50 hover:bg-white/10 hover:text-white">
                Sign out
            </button>
        </form>
    </div>
</aside>
