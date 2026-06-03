{{-- Impact Section --}}
<section id="impact" class="landing-section bg-damson-orange-muted">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Our impact</p>
            <h2 class="damson-section-title mt-3">Growing communities, one farm at a time</h2>
        </div>

        {{-- Impact Stats Grid --}}
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                <x-landing-icon name="users" class="mx-auto h-8 w-8 text-damson-orange" />
                <p class="mt-4 font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Farmers Supported</p>
            </div>
            <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                <x-landing-icon name="chart" class="mx-auto h-8 w-8 text-damson-orange" />
                <p class="mt-4 font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['yield_improved_pct'] }}" data-suffix="%">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Mushroom Yield Improved</p>
            </div>
            <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                <x-landing-icon name="book" class="mx-auto h-8 w-8 text-damson-orange" />
                <p class="mt-4 font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['training_sessions'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Training Sessions Conducted</p>
            </div>
            <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                <x-landing-icon name="target" class="mx-auto h-8 w-8 text-damson-orange" />
                <p class="mt-4 font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['districts_reached'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Districts Reached</p>
            </div>
        </div>
    </div>
</section>
