{{-- Core Values Section --}}
<section class="page-section page-section-alt">
    <div class="page-shell">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Our core values</p>
            <h2 class="damson-section-title mt-3">What guides our work</h2>
        </div>

        {{-- Values Grid --}}
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @php
                $values = [
                    ['icon' => 'award', 'title' => 'Quality Excellence', 'text' => 'We deliver the best products and services without compromise.'],
                    ['icon' => 'handshake', 'title' => 'Empowerment', 'text' => 'We equip farmers with knowledge, tools, and opportunities.'],
                    ['icon' => 'lightbulb', 'title' => 'Innovation', 'text' => 'We adopt modern methods to improve productivity.'],
                    ['icon' => 'target', 'title' => 'Integrity', 'text' => 'We operate with honesty, transparency, and professionalism.'],
                ];
            @endphp

            @foreach ($values as $value)
                <article class="landing-card text-center">
                    <div class="landing-icon-wrap mx-auto">
                        <x-landing-icon :name="$value['icon']" class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-brand-950">{{ $value['title'] }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $value['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
