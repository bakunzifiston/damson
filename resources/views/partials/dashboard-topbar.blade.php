<header class="sticky top-0 z-30 shrink-0">
    <div class="mx-4 mt-4 flex flex-col gap-3 rounded-2xl border border-stone-200/90 bg-white px-4 py-3 shadow-[0_2px_8px_-2px_rgba(0,68,43,0.08)] sm:mx-6 sm:flex-row sm:items-center sm:justify-between lg:mx-8">
        <details class="group md:hidden">
            <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl bg-brand-950 px-4 py-2.5 text-sm font-semibold text-white [&::-webkit-details-marker]:hidden">
                Menu
                <span class="text-damson-yellow" aria-hidden="true">▼</span>
            </summary>
            <div class="mt-2 space-y-1 rounded-xl border border-stone-200 bg-white p-2 shadow-sm">
                <a href="{{ route('data-hub.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Overview</a>
                <a href="{{ route('data-hub.products.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Products</a>
                <a href="{{ route('data-hub.orders.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Orders</a>
                <a href="{{ route('data-hub.module', ['module' => 'purchases']) }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Purchases</a>
                <a href="{{ route('data-hub.module', ['module' => 'sales']) }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Sales</a>
                <a href="{{ route('data-hub.module', ['module' => 'dmms']) }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">DMMS</a>
                <a href="{{ route('data-hub.module', ['module' => 'incubation']) }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Incubation</a>
                <a href="{{ route('data-hub.module', ['module' => 'contacts']) }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Messages</a>
                <hr class="my-1 border-stone-100">
                <a href="{{ route('forms.hub') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Forms hub</a>
                <a href="{{ route('store.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Store</a>
                <a href="{{ route('learning.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Learning</a>
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-brand-50">Website</a>
            </div>
        </details>

        <div class="hidden min-w-0 flex-1 md:block">
            <label class="sr-only" for="dashboard-search">Search</label>
            <input id="dashboard-search" type="search" placeholder="Search records…" disabled
                   class="w-full max-w-md rounded-xl border-0 bg-stone-100 px-4 py-2.5 text-sm text-stone-500 placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-brand-900/15 disabled:cursor-not-allowed"
                   title="Coming soon">
        </div>

        <div class="flex items-center justify-end gap-3 sm:gap-4">
            <span class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-stone-100 text-stone-500" title="Notifications" aria-hidden="true">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-damson-orange ring-2 ring-white"></span>
            </span>
            <div class="flex items-center gap-2 rounded-xl border border-stone-200/80 bg-stone-50 py-1.5 pl-1.5 pr-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-900 text-xs font-bold text-damson-yellow" aria-hidden="true">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <div class="hidden min-w-0 sm:block">
                    <p class="truncate text-xs font-semibold text-stone-900">{{ auth()->user()->name }}</p>
                    <p class="truncate text-[10px] text-stone-500">Staff</p>
                </div>
            </div>
        </div>
    </div>
</header>
