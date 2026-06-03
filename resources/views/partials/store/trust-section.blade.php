{{-- Trust Signals Section --}}
<section class="page-section page-section-alt border-t border-stone-200/80">
    <div class="page-shell">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @php
                $trustItems = [
                    ['icon' => 'award', 'title' => 'Quality Guarantee', 'text' => 'Trusted spawn and mushroom products.'],
                    ['icon' => 'package', 'title' => 'Fast Fulfillment', 'text' => 'Reliable supply for your farm.'],
                    ['icon' => 'handshake', 'title' => 'Customer Support', 'text' => 'Guidance from our expert team.'],
                    ['icon' => 'target', 'title' => 'Secure Checkout', 'text' => 'Simple ordering through our store.'],
                ];
            @endphp

            @foreach ($trustItems as $trust)
                <article class="landing-card text-center">
                    <x-landing-icon :name="$trust['icon']" class="mx-auto h-7 w-7 text-damson-orange" />
                    <h3 class="mt-3 text-sm font-semibold text-brand-950">{{ $trust['title'] }}</h3>
                    <p class="mt-1 text-xs text-stone-600">{{ $trust['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
