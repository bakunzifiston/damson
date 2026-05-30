@extends('layouts.site')

@section('title', 'Home')

@section('content')
    @php
        $sym = config('app.currency_symbol', '$');
        $stats = config('damson.stats');
        $heroSlides = [
            damson_asset('images/home-banner-mushroom.png'),
            damson_asset('images/african-mushroom.png'),
            damson_asset('images/dried-oyster-mushroom.png'),
        ];
    @endphp

    <div class="landing-page">
        {{-- Hero --}}
        <section class="relative flex min-h-[72vh] items-end overflow-hidden sm:min-h-[76vh] sm:items-center">
            <div id="hero-slider" class="absolute inset-0" aria-hidden="true">
                @foreach ($heroSlides as $slideSrc)
                    <div class="hero-slide {{ $loop->first ? 'is-active' : '' }} absolute inset-0">
                        <img src="{{ $slideSrc }}" alt="" class="h-full w-full scale-105 object-cover" width="2000" height="1333" @if($loop->first) fetchpriority="high" @endif loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                    </div>
                @endforeach
                <div class="absolute inset-0 z-[1] bg-gradient-to-t from-black/90 via-black/55 to-black/25"></div>
                <div class="absolute inset-0 z-[1] bg-gradient-to-r from-black/50 via-transparent to-black/20"></div>
            </div>
            <div class="absolute bottom-20 left-1/2 z-10 flex -translate-x-1/2 gap-2 sm:bottom-24" data-hero-dots role="tablist" aria-label="Banner slides">
                @foreach ($heroSlides as $i => $slideSrc)
                    <button type="button" class="hero-dot {{ $loop->first ? 'is-active' : '' }}" data-hero-go="{{ $i }}" aria-label="Show slide {{ $i + 1 }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
            <div class="relative z-10 mx-auto w-full max-w-7xl px-4 pb-12 pt-24 sm:px-6 sm:pb-16 sm:pt-28 lg:px-8">
                <div class="max-w-3xl" data-reveal>
                    <p class="landing-eyebrow text-damson-yellow">Rwanda&rsquo;s mushroom value chain partner</p>
                    <h1 class="mt-4 font-display text-2xl font-semibold leading-[1.12] tracking-tight text-white sm:text-3xl lg:text-4xl">
                        Welcome to DAMSON MUSHROOM FARM LTD
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-stone-200 sm:text-lg">
                        Complete, innovative solutions across the mushroom value chain — from fresh produce and spawn to training and DMMS smart farming technology.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('store.index') }}" class="damson-btn-accent rounded-xl px-6 py-3">Explore Products</a>
                        <a href="{{ route('learning.index') }}" class="landing-btn-ghost rounded-xl px-6 py-3">Join Training</a>
                    </div>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-3 lg:max-w-3xl" data-reveal>
                    <div class="landing-glass">
                        <p class="text-2xl font-semibold text-white"><span data-count="{{ $stats['years_experience'] }}" data-suffix="+">0</span></p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">Years of Experience</p>
                    </div>
                    <div class="landing-glass">
                        <p class="text-2xl font-semibold text-white"><span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span></p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">Farmers Supported</p>
                    </div>
                    <div class="landing-glass sm:col-span-1">
                        <p class="text-2xl font-semibold text-white"><span data-count="{{ $stats['products_delivered'] }}" data-suffix="+">0</span></p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-brand-100/80">Products Delivered</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mission & Vision --}}
        <section id="mission-vision" class="landing-section bg-brand-50/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow">Mission &amp; vision</p>
                    <h2 class="damson-section-title mt-3">How we see and serve the future</h2>
                </div>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <article class="landing-card-dark group h-full" data-reveal>
                        <div class="flex h-full flex-col">
                            <div class="landing-icon-wrap-accent shrink-0 transition group-hover:scale-105">
                                <x-landing-icon name="eye" class="h-6 w-6" />
                            </div>
                            <p class="mt-5 text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-yellow">Vision</p>
                            <h3 class="mt-2 font-display text-xl font-semibold text-white sm:text-2xl">Growing Mushrooms, Growing Livelihoods, Empowering Communities</h3>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-brand-100/90 sm:text-base">
                                To become Rwanda&rsquo;s leading mushroom agribusiness and a regional hub for mushroom training and innovation.
                            </p>
                        </div>
                    </article>
                    <article class="landing-card group h-full bg-white" data-reveal>
                        <div class="flex h-full flex-col">
                            <div class="landing-icon-wrap shrink-0 transition group-hover:scale-105">
                                <x-landing-icon name="target" class="h-6 w-6" />
                            </div>
                            <p class="mt-5 text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Mission</p>
                            <h3 class="mt-2 font-display text-xl font-semibold text-brand-950 sm:text-2xl">How we show up every day</h3>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600 sm:text-base">
                                To deliver high-quality mushroom products and innovative farming solutions that empower farmers, improve livelihoods, and promote sustainable agriculture.
                            </p>
                            <a href="{{ route('about') }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Our story <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- Featured products --}}
        <section id="featured-products" class="landing-section bg-gradient-to-b from-brand-50/80 to-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow">Store</p>
                    <h2 class="damson-section-title mt-3">Featured products</h2>
                    <p class="damson-prose mt-3 text-base">
                        Top picks from our catalog — quality mushrooms, spawn, and farm essentials.
                    </p>
                </div>

                @if ($featuredProducts->isNotEmpty())
                    <ul class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                        @foreach ($featuredProducts as $product)
                            <li data-reveal>
                                <article class="featured-product-card group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-[0_16px_48px_-32px_rgba(0,68,43,0.28)] ring-1 ring-brand-900/8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_56px_-32px_rgba(0,68,43,0.35)]">
                                    <a href="{{ route('store.show', $product) }}" class="relative block aspect-square overflow-hidden bg-stone-100">
                                        @if ($product->image_path)
                                            <img src="{{ damson_storage_url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" width="400" height="400">
                                        @else
                                            <div class="flex h-full items-center justify-center text-sm text-stone-400">No image</div>
                                        @endif
                                        <span class="absolute left-3 top-3 rounded-full bg-damson-orange px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">Featured</span>
                                        <span class="absolute right-3 top-3 rounded-full bg-white/95 px-2 py-0.5 text-[10px] font-semibold uppercase text-brand-900 shadow-sm">{{ str_replace('_', ' ', $product->category) }}</span>
                                    </a>
                                    <div class="flex flex-1 flex-col p-5">
                                        <h3 class="font-display text-lg font-semibold leading-snug text-brand-950 line-clamp-2">
                                            <a href="{{ route('store.show', $product) }}" class="hover:text-damson-orange">{{ $product->name }}</a>
                                        </h3>
                                        <p class="mt-3 text-2xl font-bold tracking-tight text-damson-orange">
                                            {{ $sym }}{{ number_format((float) $product->price, 0) }}
                                            <span class="text-sm font-normal text-stone-500">/ {{ $product->unit ?? 'unit' }}</span>
                                        </p>
                                        @if ($product->stock > 0)
                                            <p class="mt-1 text-xs font-medium text-brand-700">In stock</p>
                                        @else
                                            <p class="mt-1 text-xs font-medium text-stone-400">Out of stock</p>
                                        @endif
                                        <div class="mt-5 flex flex-col gap-2">
                                            <a href="{{ route('store.show', $product) }}" class="damson-btn-accent rounded-xl py-2.5 text-center text-sm font-semibold">View details</a>
                                            @if ($product->stock > 0)
                                                <form action="{{ route('store.cart.add') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="w-full rounded-xl border border-brand-900/15 py-2.5 text-sm font-semibold text-brand-950 transition hover:border-damson-orange hover:text-damson-orange">
                                                        Add to cart
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row" data-reveal>
                        <a href="{{ route('store.index') }}" class="damson-btn-accent inline-flex items-center gap-2 rounded-full px-8 py-3 text-sm font-semibold">
                            View all products
                            <x-landing-icon name="chevron-right" class="h-4 w-4" />
                        </a>
                        <a href="{{ route('store.cart') }}" class="damson-btn-outline rounded-full px-8 py-3 text-sm font-semibold">View cart</a>
                    </div>
                @else
                    <div class="mx-auto mt-12 max-w-md rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-14 text-center shadow-sm" data-reveal>
                        <x-landing-icon name="package" class="mx-auto h-12 w-12 text-stone-300" />
                        <p class="mt-4 text-sm text-stone-600">No featured products yet. Add active products in the dashboard.</p>
                        <a href="{{ route('store.index') }}" class="damson-btn mt-6 inline-flex rounded-full px-6 py-2.5 text-sm">Go to store</a>
                    </div>
                @endif
            </div>
        </section>

        {{-- Our Story --}}
        <section id="our-story" class="landing-section bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                    <div class="relative overflow-hidden rounded-3xl shadow-lg" data-reveal>
                        <img src="{{ damson_asset('images/home-banner-mushroom.png') }}" alt="DAMSON mushroom farm" class="aspect-[4/3] w-full object-cover" width="900" height="675">
                        <div class="absolute inset-0 rounded-3xl ring-1 ring-inset ring-brand-900/10"></div>
                    </div>
                    <div data-reveal>
                        <p class="landing-eyebrow">Our story</p>
                        <h2 class="damson-section-title mt-3">Damson Mushroom Business Limited</h2>
                        <p class="damson-prose mt-4 text-base">
                            At DAMSON MUSHROOM FARM LTD, we go beyond mushroom production — we deliver complete, innovative solutions across the entire mushroom value chain. From high-quality fresh and processed mushrooms to reliable spawn, organic compost, and smart farming technologies like DMMS, we support farmers at every stage.
                        </p>
                        <div class="mt-8 aspect-video overflow-hidden rounded-2xl border border-stone-200 shadow-sm">
                            <iframe class="h-full w-full" src="https://www.youtube.com/embed/c4c-ky2IPlQ" title="DAMSON Mushroom Farm" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                    <div class="landing-stat">
                        <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['farmers_trained'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Farmers Trained</p>
                    </div>
                    <div class="landing-stat">
                        <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['spawn_produced'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Spawn Produced</p>
                    </div>
                    <div class="landing-stat">
                        <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['years_experience'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Years in Operation</p>
                    </div>
                    <div class="landing-stat">
                        <p class="font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['products_sold'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Products Sold</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- What We Do --}}
        <section id="services" class="landing-section bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow">What we do</p>
                    <h2 class="damson-section-title mt-3">Core business areas</h2>
                    <p class="damson-prose mt-3">Supporting every step of mushroom farming and agribusiness growth.</p>
                </div>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @php
                        $services = [
                            ['icon' => 'sprout', 'title' => 'Mushroom Production', 'text' => 'Commercial cultivation with controlled, hygienic, and scientifically guided methods for consistent quality and year-round supply.', 'link' => null],
                            ['icon' => 'flask', 'title' => 'Spawn Production', 'text' => 'High-quality, contamination-free spawn with strong germination and reliable yields for better productivity and lower farming risk.', 'link' => route('store.index')],
                            ['icon' => 'book', 'title' => 'Training & Capacity Building', 'text' => 'Practical programs covering cultivation, farm setup, pest and disease control, and business/marketing skills.', 'link' => route('learning.index')],
                            ['icon' => 'cpu', 'title' => 'DMMS Technology Solutions', 'text' => 'Smart monitoring with the DAMSON Mushroom Monitoring System to protect yields, reduce losses, and optimize growing conditions.', 'link' => route('forms.dmms')],
                            ['icon' => 'handshake', 'title' => 'Farmer Support Services', 'text' => 'Ongoing technical guidance, quality inputs, and a strong farmer network so growers succeed at every stage.', 'link' => route('contact')],
                        ];
                    @endphp
                    @foreach ($services as $i => $service)
                        <article class="landing-card flex flex-col" data-reveal @if($i > 2) style="transition-delay: {{ ($i - 3) * 80 }}ms" @endif>
                            <div class="landing-icon-wrap {{ $i % 2 === 0 ? '' : '!bg-damson-orange' }}">
                                <x-landing-icon :name="$service['icon']" class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 font-display text-lg font-semibold text-brand-950">{{ $service['title'] }}</h3>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-600">{{ $service['text'] }}</p>
                            @if ($service['link'])
                                <a href="{{ $service['link'] }}" class="mt-4 inline-flex text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Learn more →</a>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Why Choose Us --}}
        <section id="why-us" class="landing-section bg-brand-900 text-brand-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow text-damson-yellow">Why choose us</p>
                    <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">Built for growers who demand results</h2>
                </div>
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
                            <h3 class="mt-4 font-display text-lg font-semibold text-white">{{ $feature['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-brand-100/85">{{ $feature['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Impact --}}
        <section id="impact" class="landing-section bg-damson-orange-muted">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <p class="landing-eyebrow">Our impact</p>
                    <h2 class="damson-section-title mt-3">Growing communities, one farm at a time</h2>
                </div>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                        <x-landing-icon name="users" class="mx-auto h-8 w-8 text-damson-orange" />
                        <p class="mt-4 font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['farmers_supported'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Farmers Supported</p>
                    </div>
                    <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                        <x-landing-icon name="chart" class="mx-auto h-8 w-8 text-damson-orange" />
                        <p class="mt-4 font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['yield_improved_pct'] }}" data-suffix="%">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Mushroom Yield Improved</p>
                    </div>
                    <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                        <x-landing-icon name="book" class="mx-auto h-8 w-8 text-damson-orange" />
                        <p class="mt-4 font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['training_sessions'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Training Sessions Conducted</p>
                    </div>
                    <div class="landing-stat border-damson-orange/20 bg-white" data-reveal>
                        <x-landing-icon name="target" class="mx-auto h-8 w-8 text-damson-orange" />
                        <p class="mt-4 font-display text-3xl font-semibold text-brand-900"><span data-count="{{ $stats['districts_reached'] }}" data-suffix="+">0</span></p>
                        <p class="mt-2 text-sm font-medium text-stone-600">Districts Reached</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Testimonials --}}
        @if ($testimonials->isNotEmpty())
            <section id="testimonials" class="landing-section relative overflow-hidden bg-brand-950">
                <div class="pointer-events-none absolute -left-32 top-0 h-64 w-64 rounded-full bg-damson-orange/20 blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-damson-yellow/10 blur-3xl" aria-hidden="true"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center text-center lg:flex-row lg:items-end lg:justify-between lg:text-left" data-reveal>
                        <div class="max-w-xl">
                            <p class="landing-eyebrow text-damson-yellow">Testimonials</p>
                            <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">From growers &amp; partners</h2>
                            <p class="mt-3 text-sm leading-relaxed text-brand-100/80 sm:text-base">Real experiences from farmers and partners working with DAMSON across Rwanda and the region.</p>
                        </div>
                        <a href="{{ route('success-stories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:border-damson-yellow/50 hover:bg-white/15 lg:mt-0">
                            All stories
                            <x-landing-icon name="chevron-right" class="h-4 w-4" />
                        </a>
                    </div>

                    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($testimonials as $t)
                            <article class="testimonial-card group flex flex-col rounded-2xl border border-white/10 bg-white/[0.07] p-6 shadow-lg backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:border-damson-orange/40 hover:bg-white/[0.1] sm:p-7" data-reveal>
                                <div class="flex items-start justify-between gap-3">
                                    <x-landing-icon name="quote" class="h-9 w-9 shrink-0 text-damson-orange/90" />
                                    <div class="flex gap-0.5 text-damson-yellow" aria-label="5 out of 5 stars">
                                        @for ($s = 0; $s < 5; $s++)
                                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                @if ($t->headline)
                                    <p class="mt-4 text-[11px] font-semibold uppercase tracking-[0.14em] text-damson-yellow/90">{{ Str::limit($t->headline, 60) }}</p>
                                @endif
                                <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-brand-50/95 sm:text-[15px]">
                                    &ldquo;{{ Str::limit($t->quote, 280) }}&rdquo;
                                </blockquote>
                                <footer class="mt-6 flex items-center gap-3 border-t border-white/10 pt-5">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-damson-orange to-brand-700 text-base font-semibold text-white ring-2 ring-white/20" aria-hidden="true">
                                        {{ strtoupper(substr($t->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-white">{{ $t->name }}</p>
                                        @if ($t->location)
                                            <p class="truncate text-xs text-brand-100/70">{{ $t->location }}</p>
                                        @endif
                                    </div>
                                </footer>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- CTA --}}
        <section class="relative overflow-hidden py-14 sm:py-16">
            <img src="{{ damson_asset('images/home-banner-mushroom.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover" aria-hidden="true">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-950/92 via-brand-900/85 to-brand-800/75"></div>
            <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
                <h2 class="font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl lg:text-5xl">
                    Ready to Start Your Mushroom Farming Journey?
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-brand-100/90 sm:text-lg">
                    Get quality spawn, expert training, and the support you need to build a profitable mushroom business.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('store.index') }}" class="damson-btn-accent rounded-xl px-6 py-3">Buy Spawn</a>
                    <a href="{{ route('learning.index') }}" class="landing-btn-ghost rounded-xl px-6 py-3">Join Training</a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-damson-yellow bg-damson-yellow px-6 py-3 text-sm font-semibold text-brand-950 transition hover:bg-damson-yellow-hover">Contact Us</a>
                </div>
            </div>
        </section>
    </div>
@endsection
