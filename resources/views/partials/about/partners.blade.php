{{-- Partners Section --}}
<section class="page-section bg-white">
    <div class="page-shell">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Partners</p>
            <h2 class="damson-section-title mt-3">Collaborators &amp; supporters</h2>
        </div>

        {{-- Partners Grid --}}
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @php
                $partners = ['Farmer Cooperatives', 'Agribusiness Networks', 'Training Institutions', 'Local Markets'];
            @endphp

            @foreach ($partners as $partner)
                <div class="flex h-24 items-center justify-center rounded-2xl border border-dashed border-brand-300/60 bg-brand-50 px-4 text-center text-sm font-semibold text-brand-800">
                    {{ $partner }}
                </div>
            @endforeach
        </div>
    </div>
</section>
