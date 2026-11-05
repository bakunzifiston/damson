{{-- Sidebar content: rendered once for desktop (sticky) and once inside the mobile drawer. --}}
<div class="flex h-full flex-col bg-brand-950 text-brand-100">
    <a href="{{ route('data-hub.index') }}" class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
        <img src="{{ asset('images/logo.png') }}" alt="" width="40" height="40" class="h-10 w-10 rounded-full object-cover ring-2 ring-white/20">
        <span>
            <span class="block font-display text-lg font-semibold leading-tight text-white">DAMSON</span>
            <span class="block text-[11px] font-medium uppercase tracking-wider text-damson-yellow/90">Staff dashboard</span>
        </span>
    </a>

    <div class="flex-1 overflow-y-auto px-3 py-5">
        @include('partials.dashboard-nav')
    </div>

    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10 text-sm font-bold text-damson-yellow" aria-hidden="true">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-brand-200/80">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="post" class="mt-3">
            @csrf
            <button type="submit" class="w-full rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-brand-100 transition hover:border-white/30 hover:bg-white/10 hover:text-white">Sign out</button>
        </form>
    </div>
</div>
