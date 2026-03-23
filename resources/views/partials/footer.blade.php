@php
    $c = config('damson.contact');
    $s = config('damson.social');
@endphp
<footer class="mt-auto border-t border-white/10 bg-brand-950 text-brand-100">
    <div class="h-1 bg-gradient-to-r from-damson-yellow via-damson-orange to-damson-yellow opacity-90" aria-hidden="true"></div>
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
        <div class="flex flex-col gap-12 lg:flex-row lg:justify-between lg:gap-16">
            <div class="max-w-xs">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="" width="40" height="40" class="h-10 w-10 rounded-full object-cover ring-2 ring-white/25" role="presentation">
                    <div>
                        <p class="font-display text-lg font-semibold text-white">DAMSON</p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-brand-100/80 leading-relaxed">Mushroom tubes, spawn, and DMMS.</p>
            </div>
            <div class="flex flex-wrap gap-x-14 gap-y-8 text-sm">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Site</p>
                    <ul class="mt-3 space-y-2.5 text-brand-100">
                        <li><a href="{{ route('products') }}" class="transition hover:text-white">Products</a></li>
                        <li><a href="{{ route('learning.index') }}" class="transition hover:text-white">Learning</a></li>
                        <li><a href="{{ route('forms.hub') }}" class="transition hover:text-white">Forms</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Contact</p>
                    <ul class="mt-3 space-y-2.5 text-brand-100">
                        <li><a href="mailto:{{ $c['email'] }}" class="transition hover:text-damson-yellow">{{ $c['email'] }}</a></li>
                        <li><a href="tel:{{ preg_replace('/\s+/', '', $c['phone']) }}" class="transition hover:text-damson-yellow">{{ $c['phone'] }}</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/45">Social</p>
                    <ul class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-brand-100">
                        <li><a href="{{ $s['facebook'] }}" class="transition hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">Facebook</a></li>
                        <li><a href="{{ $s['instagram'] }}" class="transition hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">Instagram</a></li>
                        <li><a href="{{ $s['linkedin'] }}" class="transition hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">LinkedIn</a></li>
                        <li><a href="{{ $s['youtube'] }}" class="transition hover:text-damson-yellow" rel="noopener noreferrer" target="_blank">YouTube</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="mt-12 border-t border-white/10 pt-8 text-center text-xs leading-relaxed text-brand-100/65">
            {{ $c['address'] }}<br>
            <span class="mt-1 inline-block">&copy; {{ date('Y') }} DAMSON Mushroom Farm Ltd</span>
        </p>
    </div>
</footer>
