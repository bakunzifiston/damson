@php
    $c = config('damson.contact');
    $s = config('damson.social');
@endphp
<footer class="mt-auto border-t border-white/10 bg-brand-950 text-brand-100">
    <div class="h-1 bg-gradient-to-r from-damson-yellow via-damson-orange to-damson-yellow opacity-90" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-10">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="" width="44" height="44" class="h-11 w-11 rounded-full object-cover ring-2 ring-white/25" role="presentation">
                    <div>
                        <p class="font-display text-xl font-semibold text-white">DAMSON</p>
                        <p class="text-xs text-brand-100/70">Mushroom Farm Ltd</p>
                    </div>
                </div>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-brand-100/80">
                    Premium mushrooms, quality spawn, practical training, and DMMS smart farming solutions across Rwanda.
                </p>
                <div class="mt-6">
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Follow us</p>
                    <ul class="mt-3 flex flex-wrap gap-3">
                        <li><a href="{{ $s['facebook'] }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-sm transition hover:border-damson-yellow hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">Facebook</a></li>
                        <li><a href="{{ $s['instagram'] }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-sm transition hover:border-damson-yellow hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">Instagram</a></li>
                        <li><a href="{{ $s['linkedin'] }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-sm transition hover:border-damson-yellow hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">LinkedIn</a></li>
                        <li><a href="{{ $s['youtube'] }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-sm transition hover:border-damson-yellow hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">YouTube</a></li>
                    </ul>
                </div>
            </div>

            <div class="grid gap-10 sm:grid-cols-2 lg:col-span-5 lg:grid-cols-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Quick links</p>
                    <ul class="mt-3 space-y-2.5 text-sm text-brand-100">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li><a href="{{ route('about') }}" class="transition hover:text-white">About</a></li>
                        <li><a href="{{ route('store.index') }}" class="transition hover:text-white">Store</a></li>
                        <li><a href="{{ route('learning.index') }}" class="transition hover:text-white">Learning</a></li>
                        <li><a href="{{ route('success-stories') }}" class="transition hover:text-white">Success stories</a></li>
                        <li><a href="{{ route('contact') }}" class="transition hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Products</p>
                    <ul class="mt-3 space-y-2.5 text-sm text-brand-100">
                        <li><a href="{{ route('store.index') }}" class="transition hover:text-white">Fresh mushrooms</a></li>
                        <li><a href="{{ route('store.index') }}" class="transition hover:text-white">Mushroom tubes / spawn</a></li>
                        <li><a href="{{ route('store.index') }}" class="transition hover:text-white">Browse all products</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Services</p>
                    <ul class="mt-3 space-y-2.5 text-sm text-brand-100">
                        <li><a href="{{ route('home') }}#services" class="transition hover:text-white">Production</a></li>
                        <li><a href="{{ route('learning.index') }}" class="transition hover:text-white">Training</a></li>
                        <li><a href="{{ route('forms.dmms') }}" class="transition hover:text-white">DMMS</a></li>
                        <li><a href="{{ route('forms.hub') }}" class="transition hover:text-white">Forms hub</a></li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Contact</p>
                <ul class="mt-3 space-y-2.5 text-sm text-brand-100">
                    <li><a href="mailto:{{ $c['email'] }}" class="transition hover:text-damson-yellow">{{ $c['email'] }}</a></li>
                    <li><a href="tel:{{ preg_replace('/\s+/', '', $c['phone']) }}" class="transition hover:text-damson-yellow">{{ $c['phone'] }}</a></li>
                    <li class="text-brand-100/75">{{ $c['address'] }}</li>
                </ul>
                <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Newsletter</p>
                    <p class="mt-2 text-xs text-brand-100/75">Updates on products, training, and farm tips.</p>
                    <form id="newsletter-form" class="mt-3 flex flex-col gap-2 sm:flex-row">
                        <label class="sr-only" for="newsletter-email">Email</label>
                        <input type="email" id="newsletter-email" name="email" required placeholder="you@email.com" class="min-w-0 flex-1 rounded-lg border border-white/15 bg-brand-900/50 px-3 py-2 text-sm text-white placeholder:text-brand-100/40 focus:border-damson-orange focus:outline-none focus:ring-1 focus:ring-damson-orange">
                        <button type="submit" class="damson-btn-accent shrink-0 rounded-lg px-4 py-2 text-sm">Subscribe</button>
                    </form>
                    <p id="newsletter-note" class="mt-2 hidden text-xs text-damson-yellow" role="status"></p>
                </div>
            </div>
        </div>

        <p class="mt-12 border-t border-white/10 pt-8 text-center text-xs text-brand-100/65">
            &copy; {{ date('Y') }} DAMSON Mushroom Farm Ltd. All rights reserved.
        </p>
    </div>
</footer>
