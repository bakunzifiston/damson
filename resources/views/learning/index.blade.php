@extends('layouts.site')

@section('title', 'Learning')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Training &amp; Learning</h1>
            <p class="mt-2 text-sm text-stone-500 sm:text-base">Practical skills, business knowledge, and continuous support for mushroom farmers.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div class="mb-8 rounded-2xl border border-stone-200 bg-white p-6">
            <h2 class="text-xs font-semibold uppercase tracking-[0.18em] text-damson-orange">What You Gain</h2>
            <ul class="mt-4 grid gap-2 text-sm text-stone-700 sm:grid-cols-2">
                <li>✔ Practical farming skills</li>
                <li>✔ Business knowledge</li>
                <li>✔ Access to inputs</li>
                <li>✔ Continuous support</li>
            </ul>
        </div>
        <div class="grid gap-px overflow-hidden rounded-lg border border-brand-900/15 bg-brand-900/15 sm:grid-cols-2">
            <a href="{{ route('learning.blog.index') }}" class="bg-damson-panel p-6 hover:bg-brand-100/45 sm:p-8">
                <h2 class="font-medium text-stone-900">Blog</h2>
                <p class="mt-1 text-sm text-stone-500">Articles and updates</p>
            </a>
            <a href="{{ route('learning.guides.index') }}" class="bg-damson-panel p-6 hover:bg-brand-100/45 sm:p-8">
                <h2 class="font-medium text-stone-900">Guides</h2>
                <p class="mt-1 text-sm text-stone-500">Step-by-step</p>
            </a>
            <a href="{{ route('learning.faqs') }}" class="bg-damson-panel p-6 hover:bg-brand-100/45 sm:p-8">
                <h2 class="font-medium text-stone-900">FAQs</h2>
                <p class="mt-1 text-sm text-stone-500">Common questions</p>
            </a>
            <a href="{{ route('learning.library') }}" class="bg-damson-panel p-6 hover:bg-brand-100/45 sm:p-8">
                <h2 class="font-medium text-stone-900">Library</h2>
                <p class="mt-1 text-sm text-stone-500">Documents and links</p>
            </a>
        </div>
        <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-6">
            <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Who We Serve</h3>
            <p class="mt-3 text-sm leading-relaxed text-stone-600">
                Households, restaurants and hotels, retailers, farmers and cooperatives, and youth entrepreneurs.
            </p>
        </div>
    </div>
@endsection
