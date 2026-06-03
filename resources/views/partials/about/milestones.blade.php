{{-- Journey & Milestones Section --}}
<section class="page-section bg-white">
    <div class="page-shell">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Our journey</p>
            <h2 class="damson-section-title mt-3">Milestones that shaped DAMSON</h2>
        </div>

        {{-- Timeline --}}
        <div class="relative mt-14 space-y-8" data-reveal>
            <div class="timeline-line hidden sm:block" aria-hidden="true"></div>

            @php
                $milestones = [
                    ['year' => '2010', 'title' => 'Farm foundation', 'text' => 'Started commercial mushroom production with a focus on quality and hygiene.'],
                    ['year' => '2015', 'title' => 'Spawn production scale-up', 'text' => 'Expanded reliable tube and spawn supply for farmers across Rwanda.'],
                    ['year' => '2019', 'title' => 'Training programs launched', 'text' => 'Introduced hands-on farmer training and capacity building.'],
                    ['year' => '2022', 'title' => 'DMMS innovation', 'text' => 'Deployed smart monitoring solutions to protect yields and reduce losses.'],
                    ['year' => 'Today', 'title' => 'Regional growth', 'text' => 'Serving farmers, cooperatives, and partners across multiple districts.'],
                ];
            @endphp

            @foreach ($milestones as $milestone)
                <article class="relative rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:ml-auto sm:max-w-md sm:odd:ml-0 sm:odd:mr-auto lg:max-w-lg">
                    <p class="text-sm font-bold text-damson-orange">{{ $milestone['year'] }}</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-brand-950">{{ $milestone['title'] }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $milestone['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
