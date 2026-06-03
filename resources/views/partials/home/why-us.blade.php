{{-- Why Choose Us Section --}}
<section id="why-us" class="landing-section bg-brand-900 text-brand-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow text-damson-yellow">Why choose us</p>
            <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                Built for growers who demand results
            </h2>
        </div>

        {{-- Features Grid --}}
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $features = [
                    ['icon' => 'award', 'title' => 'Expert Team', 'text' => 'Seasoned specialists in production, spawn, and farm systems.'],
                    ['icon' => 'flask', 'title' => 'Quality Spawn', 'text' => 'Reliable tubes and spawn with strong germination and consistency.'],
                    ['icon' => 'book', 'title' => 'Practical Training', 'text' => 'Hands-on programs designed for real farm conditions.'],
                    ['icon' => 'leaf', 'title' => 'Sustainable Farming', 'text' => 'Methods that protect resources and long-term productivity.'],
                    ['icon' => 'users', 'title' => 'Farmer Support Network', 'text' => 'A community of growers backed by ongoing guidance.'],
                    ['icon' => 'lightbulb', 'title' => 'Innovation & Technology', 'text' => 'DMMS and modern tools to grow smarter, not harder.'],
                ];
            @endphp

            @foreach ($features as $feature)
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm transition hover:bg-white/10" data-reveal>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-damson-orange text-white">
                        <x-landing-icon :name="$feature['icon']" class="h-5 w-5" />
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-white">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-brand-100/85">
                        {{ $feature['text'] }}
                    </p>
                </article>
            @endforeach
        </div>
    </div>
</section>
