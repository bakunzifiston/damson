{{-- Call-to-Action Section --}}
<section class="relative overflow-hidden py-14 sm:py-16">
    {{-- Background Image & Overlay --}}
    <img
        src="{{ asset('images/home-banner-mushroom.png') }}"
        alt=""
        class="absolute inset-0 h-full w-full object-cover"
        aria-hidden="true"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-brand-950/92 via-brand-900/85 to-brand-800/75"></div>

    {{-- CTA Content --}}
    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
        <h2 class="font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl lg:text-5xl">
            Ready to Start Your Mushroom Farming Journey?
        </h2>
        <p class="mx-auto mt-4 max-w-2xl text-base text-brand-100/90 sm:text-lg">
            Get quality spawn, expert training, and the support you need to build a profitable mushroom business.
        </p>

        {{-- CTA Buttons --}}
        <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('store.index') }}" class="damson-btn-accent rounded-xl px-6 py-3">
                Buy Spawn
            </a>
            <a href="{{ route('learning.index') }}" class="landing-btn-ghost rounded-xl px-6 py-3">
                Join Training
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-damson-yellow bg-damson-yellow px-6 py-3 text-sm font-semibold text-brand-950 transition hover:bg-damson-yellow-hover">
                Contact Us
            </a>
        </div>
    </div>
</section>
