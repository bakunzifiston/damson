{{-- Products Grid --}}
<div class="min-w-0">
    {{-- Results Header & Sort --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-600">
            @if ($products->total() === 0)
                No products match your filters.
            @else
                Showing <span class="font-semibold text-brand-950">{{ $products->firstItem() }}</span>–<span class="font-semibold text-brand-950">{{ $products->lastItem() }}</span>
                of <span class="font-semibold text-brand-950">{{ $products->total() }}</span> results
            @endif
        </p>
        <div class="flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('store.cart') }}" class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm font-semibold text-brand-950 shadow-sm transition hover:border-damson-orange/40 hover:text-damson-orange">
                View cart
                @if ($storeCartCount > 0)
                    <span class="rounded-full bg-damson-orange px-2 py-0.5 text-[11px] font-bold leading-none text-white">{{ $storeCartCount > 99 ? '99+' : $storeCartCount }}</span>
                @endif
            </a>
            <div class="flex items-center gap-2">
                <label for="store-sort" class="text-xs font-medium uppercase tracking-wide text-stone-500">Sort</label>
                <select name="sort" id="store-sort" class="rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm text-stone-800 shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                    <option value="default" @selected($sort === 'default')>Default</option>
                    <option value="name" @selected($sort === 'name')>Name A–Z</option>
                    <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                    <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Products List --}}
    <ul class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @forelse ($products as $product)
            <li class="group">
                <article class="store-card flex h-full flex-col">
                    {{-- Product Image --}}
                    <div class="relative aspect-square overflow-hidden bg-stone-100">
                        @if ($product->image_path)
                            <img src="{{ '/public/storage/'.$product->image_path }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" width="600" height="600">
                        @else
                            <div class="flex h-full items-center justify-center text-sm text-stone-400">No image</div>
                        @endif
                        <div class="absolute left-3 top-3 flex gap-2 opacity-0 transition group-hover:opacity-100">
                            <a href="{{ route('store.show', $product) }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-damson-orange text-white shadow-md ring-2 ring-white/80 transition hover:bg-damson-orange-hover" title="Quick view">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Product Details --}}
                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-[10px] font-semibold uppercase tracking-wide text-stone-400">
                            {{ str_replace('_', ' ', $product->category) }}
                        </p>
                        <h2 class="mt-1 font-display text-base font-semibold leading-snug text-brand-950">
                            <a href="{{ route('store.show', $product) }}" class="hover:text-damson-orange">{{ $product->name }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-2 text-xs text-stone-500">{{ Str::limit(strip_tags($product->description), 90) }}</p>
                        <p class="mt-2 text-xs font-medium {{ $product->stock > 0 ? 'text-brand-700' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? 'In stock ('.$product->stock.')' : 'Out of stock' }}
                        </p>
                        <p class="mt-3 text-lg font-semibold text-damson-orange">
                            {{ $sym }}{{ number_format((float) $product->price, 2) }}
                            <span class="text-xs font-normal text-stone-500">/ {{ $product->unit ?? 'unit' }}</span>
                        </p>

                        {{-- Actions --}}
                        <div class="mt-auto space-y-3 pt-5">
                            <a href="{{ route('store.show', $product) }}" class="damson-btn-accent block w-full rounded-xl py-2.5 text-center text-sm font-semibold shadow-md">View details</a>
                            @if ($product->stock > 0)
                                <form action="{{ route('store.cart.add') }}" method="post" class="flex flex-wrap items-end gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <label class="flex min-w-[4.5rem] flex-1 flex-col text-[10px] font-semibold uppercase tracking-wide text-stone-500">
                                        Qty
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required
                                               class="mt-1 w-full rounded-lg border border-stone-200 px-2 py-1.5 text-sm text-stone-900 shadow-sm focus:border-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900/15">
                                    </label>
                                    <button type="submit" class="rounded-xl border border-brand-900/20 bg-white px-4 py-2 text-sm font-semibold text-brand-950 shadow-sm transition hover:border-damson-orange/40 hover:text-damson-orange">
                                        Add to cart
                                    </button>
                                </form>
                            @else
                                <p class="text-center text-xs font-medium text-stone-500">Out of stock</p>
                            @endif
                        </div>
                    </div>
                </article>
            </li>
        @empty
            <li class="col-span-full rounded-2xl border border-dashed border-brand-900/15 bg-white/60 py-16 text-center text-sm text-stone-500">
                Try widening the price range or choosing <strong class="text-brand-950">All products</strong>.
            </li>
        @endforelse
    </ul>

    {{-- Pagination --}}
    {{ $products->links('vendor.pagination.store-shop') }}
</div>
