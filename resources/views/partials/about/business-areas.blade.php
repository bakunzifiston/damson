{{-- Core Business Areas Section --}}
<section class="page-section page-section-alt">
    <div class="page-shell">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">What we do</p>
            <h2 class="damson-section-title mt-3">Core business areas</h2>
        </div>

        {{-- Business Areas Grid --}}
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $areas = [
                    ['icon' => 'sprout', 'title' => 'Mushroom Production'],
                    ['icon' => 'flask', 'title' => 'Spawn Production'],
                    ['icon' => 'book', 'title' => 'Training & Capacity Building'],
                    ['icon' => 'cpu', 'title' => 'DMMS Technology'],
                    ['icon' => 'handshake', 'title' => 'Farmer Support'],
                ];
            @endphp

            @foreach ($areas as $area)
                <article class="landing-card flex gap-4" data-reveal>
                    <div class="landing-icon-wrap shrink-0">
                        <x-landing-icon :name="$area['icon']" class="h-6 w-6" />
                    </div>
                    <h3 class="font-display text-lg font-semibold text-brand-950">{{ $area['title'] }}</h3>
                </article>
            @endforeach
        </div>
    </div>
</section>
