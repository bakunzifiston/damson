{{-- Our Story Section --}}
<section id="our-story" class="landing-section bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Content Grid --}}
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Image Column --}}
            <div class="relative overflow-hidden rounded-3xl shadow-lg" data-reveal>
                <img
                    src="{{ asset('images/home-banner-mushroom.png') }}"
                    alt="DAMSON mushroom farm"
                    class="aspect-[4/3] w-full object-cover"
                    width="900"
                    height="675"
                >
                <div class="absolute inset-0 rounded-3xl ring-1 ring-inset ring-brand-900/10"></div>
            </div>

            {{-- Text Column --}}
            <div data-reveal>
                <p class="landing-eyebrow">Our story</p>
                <h2 class="damson-section-title mt-3">Damson Mushroom Business Limited</h2>
                <p class="damson-prose mt-4 text-base">
                    At DAMSON MUSHROOM FARM LTD, we go beyond mushroom production — we deliver complete, innovative solutions across the entire mushroom value chain. From high-quality fresh and processed mushrooms to reliable spawn, organic compost, and smart farming technologies like DMMS, we support farmers at every stage.
                </p>

                {{-- YouTube Video --}}
                <div class="mt-8 aspect-video overflow-hidden rounded-2xl border border-stone-200 shadow-sm">
                    <iframe
                        class="h-full w-full"
                        src="https://www.youtube.com/embed/c4c-ky2IPlQ"
                        title="DAMSON Mushroom Farm"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
        </div>

        {{-- Story Stats Grid --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['farmers_trained'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Farmers Trained</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['spawn_produced'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Spawn Produced</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['years_experience'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Years in Operation</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['products_sold'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Products Sold</p>
            </div>
        </div>
    </div>
</section>
