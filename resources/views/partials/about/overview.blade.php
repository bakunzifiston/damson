{{-- Company Overview Section --}}
<section class="page-section bg-white">
    <div class="page-shell">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16" data-reveal>
            {{-- Image --}}
            <div class="relative overflow-hidden rounded-3xl shadow-lg">
                @php
                    $featuredImage = \App\Models\Product::whereNotNull('image_path')->first()?->image_path ?? 'products/LNInqjKmevaGh64TDEMz2pc4UbpcaL0tCJbw9fcE.jpg';
                @endphp
                <img src="{{ '/storage/' . $featuredImage }}" alt="DAMSON mushroom products" class="aspect-[4/3] w-full object-contain bg-white p-4" loading="lazy">
            </div>

            {{-- Text Content --}}
            <div>
                <p class="landing-eyebrow">Company overview</p>
                <h2 class="damson-section-title mt-3">Who we are</h2>
                <p class="damson-prose mt-4">
                    We work closely with smallholder farmers, youth entrepreneurs, women groups, cooperatives, and hospitality businesses. Our goal is to create a complete ecosystem where farmers can learn, produce, and access markets easily.
                </p>
                <p class="damson-prose mt-4">
                    Through quality mushrooms, reliable spawn, and practical training, we support a stronger and more sustainable agricultural future for Rwanda.
                </p>

                {{-- Vision & Mission Cards --}}
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <article class="landing-card">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Vision</p>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">
                            To become Rwanda&rsquo;s leading mushroom agribusiness and a regional hub for mushroom training and innovation.
                        </p>
                    </article>
                    <article class="landing-card">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-damson-orange">Mission</p>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">
                            To deliver high-quality mushroom products and innovative farming solutions that empower farmers, improve livelihoods, and promote sustainable agriculture.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>
