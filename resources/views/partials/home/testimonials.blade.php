{{-- Testimonials Section --}}
<section id="testimonials" class="landing-section relative overflow-hidden bg-brand-950">
    {{-- Background Blurs --}}
    <div class="pointer-events-none absolute -left-32 top-0 h-64 w-64 rounded-full bg-damson-orange/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-damson-yellow/10 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col items-center text-center lg:flex-row lg:items-end lg:justify-between lg:text-left" data-reveal>
            <div class="max-w-xl">
                <p class="landing-eyebrow text-damson-yellow">Testimonials</p>
                <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                    From growers &amp; partners
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-brand-100/80 sm:text-base">
                    Real experiences from farmers and partners working with DAMSON across Rwanda and the region.
                </p>
            </div>
            <a href="{{ route('success-stories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:border-damson-yellow/50 hover:bg-white/15 lg:mt-0">
                All stories
                <x-landing-icon name="chevron-right" class="h-4 w-4" />
            </a>
        </div>

        {{-- Testimonials Grid --}}
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($testimonials as $testimonial)
                <article class="testimonial-card group flex flex-col rounded-2xl border border-white/10 bg-white/[0.07] p-6 shadow-lg backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:border-damson-orange/40 hover:bg-white/[0.1] sm:p-7" data-reveal>
                    {{-- Header: Quote Icon & Star Rating --}}
                    <div class="flex items-start justify-between gap-3">
                        <x-landing-icon name="quote" class="h-9 w-9 shrink-0 text-damson-orange/90" />
                        <div class="flex gap-0.5 text-damson-yellow" aria-label="5 out of 5 stars">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    {{-- Headline --}}
                    @if ($testimonial->headline)
                        <p class="mt-4 text-[11px] font-semibold uppercase tracking-[0.14em] text-damson-yellow/90">
                            {{ Str::limit($testimonial->headline, 60) }}
                        </p>
                    @endif

                    {{-- Quote --}}
                    <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-brand-50/95 sm:text-[15px]">
                        &ldquo;{{ Str::limit($testimonial->quote, 280) }}&rdquo;
                    </blockquote>

                    {{-- Author Footer --}}
                    <footer class="mt-6 flex items-center gap-3 border-t border-white/10 pt-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-damson-orange to-brand-700 text-base font-semibold text-white ring-2 ring-white/20" aria-hidden="true">
                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-white">{{ $testimonial->name }}</p>
                            @if ($testimonial->location)
                                <p class="truncate text-xs text-brand-100/70">{{ $testimonial->location }}</p>
                            @endif
                        </div>
                    </footer>
                </article>
            @endforeach
        </div>
    </div>
</section>
