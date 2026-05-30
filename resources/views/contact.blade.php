@extends('layouts.site')

@section('title', 'Contact & support')

@section('content')
    @php
        $c = config('damson.contact');
        $s = config('damson.social');
    @endphp

    @include('partials.page-hero', [
        'title' => 'Contact & Support',
        'subtitle' => 'We usually reply within one business day. Reach out for products, training, DMMS, or partnerships.',
        'eyebrow' => 'Get in touch',
        'image' => 'images/home-banner-mushroom.png',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Contact'],
        ],
    ])

    <section class="page-section bg-white">
        <div class="page-shell">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                <article class="landing-card text-center">
                    <x-landing-icon name="mail" class="mx-auto h-8 w-8 text-damson-orange" />
                    <h3 class="mt-3 text-sm font-semibold text-brand-950">Email</h3>
                    <a href="mailto:{{ $c['email'] }}" class="mt-2 block text-sm text-damson-orange hover:text-damson-orange-hover">{{ $c['email'] }}</a>
                </article>
                <article class="landing-card text-center">
                    <svg class="mx-auto h-8 w-8 text-damson-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <h3 class="mt-3 text-sm font-semibold text-brand-950">Phone</h3>
                    <a href="tel:{{ preg_replace('/\s+/', '', $c['phone']) }}" class="mt-2 block text-sm text-damson-orange">{{ $c['phone'] }}</a>
                </article>
                <article class="landing-card text-center">
                    <x-landing-icon name="target" class="mx-auto h-8 w-8 text-damson-orange" />
                    <h3 class="mt-3 text-sm font-semibold text-brand-950">Office</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $c['address'] }}</p>
                </article>
                <article class="landing-card text-center">
                    <x-landing-icon name="calendar" class="mx-auto h-8 w-8 text-damson-orange" />
                    <h3 class="mt-3 text-sm font-semibold text-brand-950">Hours</h3>
                    <p class="mt-2 text-sm text-stone-600">Mon–Sat, 8:00–18:00</p>
                </article>
            </div>
        </div>
    </section>

    <section class="page-section page-section-alt">
        <div class="page-shell">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
                <div class="landing-card p-6 sm:p-8 lg:sticky lg:top-24" data-reveal>
                    <h2 class="font-display text-2xl font-semibold text-brand-950">Send a message</h2>
                    <p class="mt-2 text-sm text-stone-600">Fill in the form and our team will get back to you.</p>
                    <form action="{{ route('contact.store') }}" method="post" class="mt-8 space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="damson-input">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-stone-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="damson-input">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-stone-700">Phone <span class="text-stone-400">(optional)</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="damson-input">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-stone-700">Subject <span class="text-stone-400">(optional)</span></label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject', request('subject')) }}" class="damson-input">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-stone-700">Message</label>
                            <textarea name="message" id="message" rows="5" required class="damson-input">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="damson-btn-accent w-full rounded-xl py-3 text-sm font-semibold">Send message</button>
                    </form>
                </div>
                <div class="space-y-8" data-reveal>
                    <div>
                        <p class="landing-eyebrow">Quick support</p>
                        <h2 class="damson-section-title mt-2">How can we help?</h2>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                ['title' => 'Product Inquiries', 'url' => route('store.index'), 'icon' => 'package'],
                                ['title' => 'Training Registration', 'url' => route('contact').'?subject=Training', 'icon' => 'book'],
                                ['title' => 'Technical Support', 'url' => route('forms.dmms'), 'icon' => 'cpu'],
                                ['title' => 'Partnership Requests', 'url' => route('contact').'?subject=Partnership', 'icon' => 'handshake'],
                            ] as $card)
                                <a href="{{ $card['url'] }}" class="landing-card flex items-start gap-3 transition hover:border-damson-orange/40">
                                    <x-landing-icon :name="$card['icon']" class="h-6 w-6 shrink-0 text-damson-orange" />
                                    <span class="text-sm font-semibold text-brand-950">{{ $card['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-3xl border border-stone-200 shadow-sm">
                        <iframe title="DAMSON location map" class="h-64 w-full sm:h-80" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255168.88428856328!2d30.0619!3d-1.9403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258d5f3b0b%3A0x1c0b8c8c8c8c8c8c!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2s!4v1"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($faqs->isNotEmpty())
        <section class="page-section bg-white">
            <div class="page-shell max-w-3xl">
                <div class="text-center" data-reveal>
                    <p class="landing-eyebrow">FAQ</p>
                    <h2 class="damson-section-title mt-3">Frequently asked questions</h2>
                </div>
                <div class="mt-10 space-y-3" data-reveal>
                    @foreach ($faqs as $faq)
                        <details class="faq-details landing-card">
                            <summary>{{ $faq->question }}<span class="text-damson-orange" aria-hidden="true">+</span></summary>
                            <p class="mt-4 text-sm leading-relaxed text-stone-600">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
                <p class="mt-6 text-center text-sm">
                    <a href="{{ route('learning.faqs') }}" class="font-semibold text-damson-orange hover:text-damson-orange-hover">View all FAQs →</a>
                </p>
            </div>
        </section>
    @endif

    <section class="page-section page-section-alt">
        <div class="page-shell text-center" data-reveal>
            <p class="landing-eyebrow">Social</p>
            <h2 class="damson-section-title mt-3">Connect with us</h2>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ $s['facebook'] }}" target="_blank" rel="noopener noreferrer" class="damson-btn-outline rounded-xl px-5 py-2.5">Facebook</a>
                <a href="{{ $s['instagram'] }}" target="_blank" rel="noopener noreferrer" class="damson-btn-outline rounded-xl px-5 py-2.5">Instagram</a>
                <a href="{{ $s['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="damson-btn-outline rounded-xl px-5 py-2.5">LinkedIn</a>
                <a href="{{ $s['youtube'] }}" target="_blank" rel="noopener noreferrer" class="damson-btn-outline rounded-xl px-5 py-2.5">YouTube</a>
            </div>
        </div>
    </section>
@endsection
