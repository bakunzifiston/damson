{{-- Services Section --}}
<section id="services" class="landing-section bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">What we do</p>
            <h2 class="damson-section-title mt-3">Core business areas</h2>
            <p class="damson-prose mt-3">
                Supporting every step of mushroom farming and agribusiness growth.
            </p>
        </div>

        {{-- Services Grid --}}
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $services = [
                    [
                        'icon' => 'sprout',
                        'title' => 'Mushroom Production',
                        'text' => 'Commercial cultivation with controlled, hygienic, and scientifically guided methods for consistent quality and year-round supply.',
                        'link' => null,
                    ],
                    [
                        'icon' => 'flask',
                        'title' => 'Spawn Production',
                        'text' => 'High-quality, contamination-free spawn with strong germination and reliable yields for better productivity and lower farming risk.',
                        'link' => route('store.index'),
                    ],
                    [
                        'icon' => 'book',
                        'title' => 'Training & Capacity Building',
                        'text' => 'Practical programs covering cultivation, farm setup, pest and disease control, and business/marketing skills.',
                        'link' => route('learning.index'),
                    ],
                    [
                        'icon' => 'cpu',
                        'title' => 'DMMS Technology Solutions',
                        'text' => 'Smart monitoring with the DAMSON Mushroom Monitoring System to protect yields, reduce losses, and optimize growing conditions.',
                        'link' => route('forms.dmms'),
                    ],
                    [
                        'icon' => 'handshake',
                        'title' => 'Farmer Support Services',
                        'text' => 'Ongoing technical guidance, quality inputs, and a strong farmer network so growers succeed at every stage.',
                        'link' => route('contact'),
                    ],
                ];
            @endphp

            @foreach ($services as $i => $service)
                <article class="landing-card flex flex-col" data-reveal @if($i > 2) style="transition-delay: {{ ($i - 3) * 80 }}ms" @endif>
                    <div class="landing-icon-wrap {{ $i % 2 === 0 ? '' : '!bg-damson-orange' }}">
                        <x-landing-icon :name="$service['icon']" class="h-6 w-6" />
                    </div>
                    <h3 class="mt-5 font-display text-lg font-semibold text-brand-950">
                        {{ $service['title'] }}
                    </h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-600">
                        {{ $service['text'] }}
                    </p>

                    @if ($service['link'])
                        <a href="{{ $service['link'] }}" class="mt-4 inline-flex text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">
                            Learn more →
                        </a>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
