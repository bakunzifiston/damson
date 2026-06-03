{{-- Featured Products Bar --}}
@if ($featuredProducts->isNotEmpty())
    <div class="mt-10" data-reveal>
        <p class="landing-eyebrow">Featured</p>
        <h2 class="font-display text-xl font-semibold text-brand-950">Popular right now</h2>
        <ul class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredProducts as $product)
                <li>
                    <a href="{{ route('store.show', $product) }}" class="landing-card flex items-center gap-4 p-4 transition hover:border-damson-orange/40">
                        @if ($product->image_path)
                            <img src="{{ '/public/storage/'.$product->image_path }}" alt="" class="h-16 w-16 shrink-0 rounded-lg object-cover">
                        @endif
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-brand-950">{{ $product->name }}</p>
                            <p class="text-sm font-semibold text-damson-orange">{{ $sym }}{{ number_format((float) $product->price, 0) }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
