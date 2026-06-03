{{-- Mission & Vision Section --}}
<section id="mission-vision" class="landing-section bg-brand-50/80">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Mission &amp; vision</p>
            <h2 class="damson-section-title mt-3">How we see and serve the future</h2>
        </div>

        {{-- Mission & Vision Cards --}}
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            {{-- Vision Card --}}
            <article class="landing-card-dark group h-full" data-reveal>
                <div class="flex h-full flex-col">
                    <div class="landing-icon-wrap-accent shrink-0 transition group-hover:scale-105">
                        <x-landing-icon name="eye" class="h-6 w-6" />
                    </div>
                    <p class="mt-5 text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-yellow">
                        Vision
                    </p>
                    <h3 class="mt-2 font-display text-xl font-semibold text-white sm:text-2xl">
                        Growing Mushrooms, Growing Livelihoods, Empowering Communities
                    </h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-brand-100/90 sm:text-base">
                        To become Rwanda&rsquo;s leading mushroom agribusiness and a regional hub for mushroom training and innovation.
                    </p>
                </div>
            </article>

            {{-- Mission Card --}}
            <article class="landing-card group h-full bg-white" data-reveal>
                <div class="flex h-full flex-col">
                    <div class="landing-icon-wrap shrink-0 transition group-hover:scale-105">
                        <x-landing-icon name="target" class="h-6 w-6" />
                    </div>
                    <p class="mt-5 text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">
                        Mission
                    </p>
                    <h3 class="mt-2 font-display text-xl font-semibold text-brand-950 sm:text-2xl">
                        How we show up every day
                    </h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600 sm:text-base">
                        To deliver high-quality mushroom products and innovative farming solutions that empower farmers, improve livelihoods, and promote sustainable agriculture.
                    </p>
                    <a href="{{ route('about') }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">
                        Our story
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>
