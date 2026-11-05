@php
    $cartCount = \App\Http\Controllers\Store\CartController::cartCount(request());
    $cartLabel = $cartCount > 99 ? '99+' : $cartCount;
    $main = [
        ['route' => 'home', 'label' => 'Home', 'active' => request()->routeIs('home')],
        ['route' => 'about', 'label' => 'About', 'active' => request()->routeIs('about')],
        ['route' => 'learning.index', 'label' => 'Learning', 'active' => request()->is('learning*')],
        ['route' => 'store.index', 'label' => 'Store', 'active' => request()->routeIs('store.index', 'store.show')],
        ['route' => 'success-stories', 'label' => 'Stories', 'active' => request()->routeIs('success-stories')],
        ['route' => 'contact', 'label' => 'Contact', 'active' => request()->routeIs('contact')],
    ];
@endphp
<header class="sticky top-0 z-40 border-b border-stone-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/85">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="DAMSON Mushroom Farm — home">
            <img src="{{ asset('images/logo.png') }}" alt="" width="40" height="40" class="h-10 w-10 shrink-0 rounded-full object-cover ring-1 ring-brand-900/15">
            <span class="font-display text-lg font-semibold tracking-tight text-brand-950">DAMSON</span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
            @foreach ($main as $item)
                <a href="{{ route($item['route']) }}"
                   @if ($item['active']) aria-current="page" @endif
                   class="relative rounded-md px-3 py-2 text-sm font-medium transition {{ $item['active'] ? 'text-brand-900 after:absolute after:inset-x-3 after:-bottom-[13px] after:h-0.5 after:rounded-full after:bg-damson-orange' : 'text-stone-600 hover:text-brand-950' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('store.cart') }}" class="relative inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-700 transition hover:bg-stone-100 hover:text-brand-950">
                <span class="sr-only">Cart{{ $cartCount > 0 ? ', '.$cartCount.' items' : '' }}</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                @if ($cartCount > 0)
                    <span class="absolute right-0 top-0 flex h-5 min-w-5 items-center justify-center rounded-full bg-damson-orange px-1 text-[11px] font-bold leading-none text-white" aria-hidden="true">{{ $cartLabel }}</span>
                @endif
            </a>

            <div class="hidden items-center gap-2 lg:flex">
                @auth
                    <a href="{{ route('data-hub.index') }}" class="damson-btn damson-btn-sm">Dashboard</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="damson-btn-ghost damson-btn-sm">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="damson-btn-outline damson-btn-sm">Staff login</a>
                @endauth
            </div>

            <button type="button" data-menu-toggle aria-controls="site-menu" aria-expanded="false"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-700 transition hover:bg-stone-100 lg:hidden">
                <span class="sr-only">Toggle menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile / tablet menu --}}
    <div id="site-menu" class="hidden border-t border-stone-200 bg-white lg:hidden">
        <nav class="mx-auto max-w-7xl space-y-1 px-4 py-3 sm:px-6" aria-label="Mobile">
            @foreach ($main as $item)
                <a href="{{ route($item['route']) }}" @if ($item['active']) aria-current="page" @endif
                   class="block rounded-lg px-3 py-2.5 text-base font-medium {{ $item['active'] ? 'bg-brand-50 text-brand-900' : 'text-stone-700 hover:bg-stone-50' }}">{{ $item['label'] }}</a>
            @endforeach
            <div class="mt-2 border-t border-stone-100 pt-3">
                @auth
                    <a href="{{ route('data-hub.index') }}" class="damson-btn w-full">Dashboard</a>
                    <form action="{{ route('logout') }}" method="post" class="mt-2">
                        @csrf
                        <button type="submit" class="damson-btn-outline w-full">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="damson-btn-outline w-full">Staff login</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
