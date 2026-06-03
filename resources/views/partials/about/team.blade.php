{{-- Team Section --}}
<section class="page-section page-section-alt">
    <div class="page-shell">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Our team</p>
            <h2 class="damson-section-title mt-3">People behind the mission</h2>
        </div>

        {{-- Team Grid --}}
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $members = [
                    ['name' => 'Leadership Team', 'role' => 'Farm & Operations', 'initial' => 'L'],
                    ['name' => 'Training Team', 'role' => 'Capacity Building', 'initial' => 'T'],
                    ['name' => 'Technical Team', 'role' => 'DMMS & Quality', 'initial' => 'D'],
                ];
            @endphp

            @foreach ($members as $member)
                <article class="landing-card text-center" data-reveal>
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-900 text-2xl font-semibold text-white">
                        {{ $member['initial'] }}
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-brand-950">{{ $member['name'] }}</h3>
                    <p class="text-sm text-stone-500">{{ $member['role'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
