{{-- Featured Products Section --}}
@php
    $sym = config('app.currency_symbol', '$');
@endphp

<section id="featured-products" class="landing-section bg-gradient-to-b from-brand-50/80 to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="landing-eyebrow">Store</p>
            <h2 class="damson-section-title mt-3">Featured products</h2>
            <p class="damson-prose mt-3 text-base">
                Top picks from our catalog — quality mushrooms, spawn, and farm essentials.
            </p>
        </div>

        {{-- Products Grid or Empty State --}}
        @if ($featuredProducts->isNotEmpty())
            {{-- Products List --}}
            <ul class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                @foreach ($featuredProducts as $product)
                    <li data-reveal>
                        <article class="featured-product-card group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-[0_16px_48px_-32px_rgba(0,68,43,0.28)] ring-1 ring-brand-900/8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_28px_56px_-32px_rgba(0,68,43,0.35)]">
                            {{-- Product Image --}}
                            <a href="{{ route('store.show', $product) }}" class="relative block aspect-square overflow-hidden bg-stone-100">
                                @if ($product->image_path)
                                    <img
                                        src="{{ '/public/storage/'.$product->image_path }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        width="400"
                                        height="400"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center text-sm text-stone-400">
                                        No image
                                    </div>
                                @endif

                                {{-- Badges --}}
                                <span class="absolute left-3 top-3 rounded-full bg-damson-orange px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                                    Featured
                                </span>
                                <span class="absolute right-3 top-3 rounded-full bg-white/95 px-2 py-0.5 text-[10px] font-semibold uppercase text-brand-900 shadow-sm">
                                    {{ str_replace('_', ' ', $product->category) }}
                                </span>
                            </a>

                            {{-- Product Details --}}
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="font-display text-lg font-semibold leading-snug text-brand-950 line-clamp-2">
                                    <a href="{{ route('store.show', $product) }}" class="hover:text-damson-orange">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                {{-- Price --}}
                                <p class="mt-3 text-2xl font-bold tracking-tight text-damson-orange">
                                    {{ $sym }}{{ number_format((float) $product->price, 0) }}
                                    <span class="text-sm font-normal text-stone-500">
                                        / {{ $product->unit ?? 'unit' }}
                                    </span>
                                </p>

                                {{-- Stock Status --}}
                                @if ($product->stock > 0)
                                    <p class="mt-1 text-xs font-medium text-brand-700">In stock</p>
                                @else
                                    <p class="mt-1 text-xs font-medium text-stone-400">Out of stock</p>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="mt-5 flex flex-col gap-2">
                                    <a href="{{ route('store.show', $product) }}" class="damson-btn-accent rounded-xl py-2.5 text-center text-sm font-semibold">
                                        View details
                                    </a>

                                    @if ($product->stock > 0)
                                        <form action="{{ route('store.cart.add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button
                                                type="submit"
                                                class="w-full rounded-xl border border-brand-900/15 py-2.5 text-sm font-semibold text-brand-950 transition hover:border-damson-orange hover:text-damson-orange"
                                            >
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

            {{-- View All Button --}}
            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row" data-reveal>
                <a href="{{ route('store.index') }}" class="damson-btn-accent inline-flex items-center gap-2 rounded-full px-8 py-3 text-sm font-semibold">
                    View all products
                    <x-landing-icon name="chevron-right" class="h-4 w-4" />
                </a>
                <a href="{{ route('store.cart') }}" class="damson-btn-outline rounded-full px-8 py-3 text-sm font-semibold">
                    View cart
                </a>
            </div>
        @else
            {{-- Empty State --}}
            <div class="mx-auto mt-12 max-w-md rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-14 text-center shadow-sm" data-reveal>
                <x-landing-icon name="package" class="mx-auto h-12 w-12 text-stone-300" />
                <p class="mt-4 text-sm text-stone-600">
                    No featured products yet. Add active products in the dashboard.
                </p>
                <a href="{{ route('store.index') }}" class="damson-btn mt-6 inline-flex rounded-full px-6 py-2.5 text-sm">
                    Go to store
                </a>
            </div>
        @endif
    </div>
</section>
