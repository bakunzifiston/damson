@php
    $cartCount = \App\Http\Controllers\Store\CartController::cartCount(request());
    $link = fn (string $route, string $label, ?string $pattern = null) => [
        'route' => $route,
        'label' => $label,
        'active' => request()->routeIs($pattern ?? str_replace('.index', '.*', $route)) || request()->routeIs($route),
    ];
    $main = [
        $link('home', 'Home', 'home'),
        $link('about', 'About', 'about'),
        ['route' => 'learning.index', 'label' => 'Learning', 'active' => request()->is('learning*')],
        $link('store.index', 'Store', 'store.*'),
        $link('success-stories', 'Stories', 'success-stories'),
        $link('contact', 'Contact', 'contact'),
    ];
@endphp
<header class="sticky top-0 z-50 border-b border-brand-900/15 bg-white shadow-[0_1px_0_0_rgba(0,68,43,0.08)]">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="DAMSON Mushroom Farm Ltd" width="48" height="48" class="h-11 w-11 shrink-0 rounded-full object-cover ring-2 ring-brand-900/10 transition group-hover:ring-damson-orange/40 sm:h-12 sm:w-12">
            <span class="hidden font-display text-lg font-semibold tracking-tight text-brand-950 sm:inline">DAMSON</span>
        </a>
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
            @foreach ($main as $item)
                <a href="{{ route($item['route']) }}"
                   class="inline-flex items-center gap-1.5 rounded-md px-3 py-2 text-sm transition {{ $item['active'] ? 'font-semibold text-brand-900' : 'text-stone-600 hover:bg-brand-50 hover:text-brand-950' }}">
                    {{ $item['label'] }}
                    @if (($item['route'] ?? '') === 'store.cart' && $cartCount > 0)
                        <span class="rounded-full bg-damson-orange px-1.5 py-0.5 text-[10px] font-bold leading-none text-white">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    @endif
                </a>
            @endforeach
            <span class="mx-1 hidden h-4 w-px bg-stone-200 lg:block" aria-hidden="true"></span>
            @auth
                <a href="{{ route('data-hub.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-damson-orange hover:bg-damson-orange-muted">Dashboard</a>
                <form action="{{ route('logout') }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="rounded-md px-3 py-2 text-sm text-stone-500 hover:bg-brand-100/50 hover:text-stone-800">Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm text-stone-500 hover:bg-brand-100/50 hover:text-stone-800">Staff</a>
            @endauth
        </nav>
        <details class="relative lg:hidden">
            <summary class="list-none cursor-pointer rounded-lg border border-brand-900/20 bg-white px-3 py-2 text-sm font-medium text-brand-950 shadow-sm [&::-webkit-details-marker]:hidden">Menu</summary>
            <div class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-xl border border-brand-900/12 bg-white py-1 shadow-lg">
                @foreach ($main as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center justify-between gap-2 px-4 py-2.5 text-sm {{ $item['active'] ? 'bg-brand-100/60 font-semibold text-brand-900' : 'text-stone-700 hover:bg-brand-100/40' }}">
                        <span>{{ $item['label'] }}</span>
                        @if (($item['route'] ?? '') === 'store.cart' && $cartCount > 0)
                            <span class="rounded-full bg-damson-orange px-1.5 py-0.5 text-[10px] font-bold leading-none text-white">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    </a>
                @endforeach
                @auth
                    <a href="{{ route('data-hub.index') }}" class="block px-4 py-2.5 text-sm font-medium text-damson-orange hover:bg-damson-orange-muted">Dashboard</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-stone-600 hover:bg-brand-100/40">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm text-stone-600 hover:bg-brand-100/40">Staff</a>
                @endauth
            </div>
        </details>
    </div>
</header>
