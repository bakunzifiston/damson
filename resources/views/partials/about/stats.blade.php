{{-- About Stats Section --}}
<section class="page-section bg-white">
    <div class="page-shell">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Farmers Supported</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['training_sessions'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Training Sessions</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['spawn_produced'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Spawn Produced</p>
            </div>
            <div class="landing-stat">
                <p class="font-display text-3xl font-semibold text-brand-900">
                    <span data-count="{{ $stats['products_delivered'] }}" data-suffix="+">0</span>
                </p>
                <p class="mt-2 text-sm font-medium text-stone-600">Products Delivered</p>
            </div>
        </div>
    </div>
</section>
