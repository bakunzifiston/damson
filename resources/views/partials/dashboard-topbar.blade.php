{{-- Mobile/tablet top bar with drawer toggle (hidden on desktop where the sidebar is persistent). --}}
<header class="sticky top-0 z-30 flex items-center justify-between gap-3 border-b border-stone-200 bg-white px-4 py-2.5 md:hidden">
    <button type="button" data-drawer-open aria-controls="dashboard-drawer" aria-expanded="false"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-700 transition hover:bg-stone-100">
        <span class="sr-only">Open navigation</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
    <a href="{{ route('data-hub.index') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="" width="32" height="32" class="h-8 w-8 rounded-full object-cover">
        <span class="font-display text-base font-semibold text-brand-950">DAMSON</span>
    </a>
    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-900 text-sm font-bold text-damson-yellow" aria-hidden="true">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
</header>
