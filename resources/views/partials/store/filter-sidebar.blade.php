{{-- Filter Sidebar --}}
<aside class="store-panel sticky top-24 mb-10 p-6 lg:mb-0">
    <h2 class="font-display text-lg font-semibold text-damson-orange">Filter products</h2>

    {{-- Search --}}
    <div class="mt-6">
        <label for="store-search" class="text-xs font-semibold uppercase tracking-wide text-stone-500">Search</label>
        <input type="search" name="q" id="store-search" value="{{ $search }}" placeholder="Search products…"
               class="damson-input mt-1 text-sm">
    </div>

    {{-- Price Range --}}
    <div class="mt-6">
        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Price range</p>
        <p class="mt-2 text-sm font-medium text-brand-950" id="store-price-label">
            {{ $sym }}{{ number_format($minP, 2) }} — {{ $sym }}{{ number_format($maxP, 2) }}
        </p>
        <div class="mt-4 space-y-4">
            <div>
                <label for="store-min-price" class="text-xs text-stone-500">Minimum</label>
                <input type="range" name="min_price" id="store-min-price" class="mt-1 block w-full accent-damson-orange"
                       min="{{ $floor }}" max="{{ $ceil }}" step="0.01" value="{{ $minP }}">
            </div>
            <div>
                <label for="store-max-price" class="text-xs text-stone-500">Maximum</label>
                <input type="range" name="max_price" id="store-max-price" class="mt-1 block w-full accent-damson-orange"
                       min="{{ $floor }}" max="{{ $ceil }}" step="0.01" value="{{ $maxP }}">
            </div>
        </div>
    </div>

    {{-- Category --}}
    <div class="mt-8 border-t border-stone-100 pt-6">
        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Category</p>
        <ul class="mt-3 space-y-2">
            <li>
                <label class="flex cursor-pointer items-center justify-between gap-2 rounded-lg px-2 py-1.5 text-sm transition hover:bg-stone-50">
                    <span class="flex items-center gap-2">
                        <input type="radio" name="category" value="" class="border-stone-300 text-damson-orange focus:ring-damson-orange" @checked($category === '')>
                        All products
                    </span>
                    <span class="rounded-full bg-damson-orange-muted px-2 py-0.5 text-[11px] font-semibold text-damson-orange">{{ $totalCatalog }}</span>
                </label>
            </li>
            @foreach ($categoryCounts as $cat => $count)
                <li>
                    <label class="flex cursor-pointer items-center justify-between gap-2 rounded-lg px-2 py-1.5 text-sm transition hover:bg-stone-50">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="category" value="{{ $cat }}" class="border-stone-300 text-damson-orange focus:ring-damson-orange" @checked($category === $cat)>
                            {{ str_replace('_', ' ', $cat) }}
                        </span>
                        <span class="rounded-full bg-damson-orange-muted px-2 py-0.5 text-[11px] font-semibold text-damson-orange">{{ $count }}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex flex-col gap-3 border-t border-stone-100 pt-6">
        <button type="submit" class="damson-btn-accent w-full rounded-xl py-2.5 text-sm font-semibold shadow-md">Apply filters</button>
        <a href="{{ route('store.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-stone-200 bg-white py-2.5 text-sm font-semibold text-stone-600 transition hover:border-damson-orange/40 hover:text-damson-orange">
            <span aria-hidden="true">✕</span> Clear all
        </a>
    </div>
</aside>
