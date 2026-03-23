@extends('layouts.site')

@section('title', 'FAQs')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">FAQs</h1>
            <p class="mt-2 text-sm text-stone-500">Farming and products.</p>
            @if ($categories->isNotEmpty())
                <div class="mt-8 flex flex-wrap gap-2">
                    <a href="{{ route('learning.faqs') }}" class="text-sm {{ $category === null ? 'font-medium text-stone-900 underline decoration-stone-900 underline-offset-4' : 'text-stone-500 hover:text-stone-900' }}">All</a>
                    @foreach ($categories as $cat)
                        <span class="text-stone-300">·</span>
                        <a href="{{ route('learning.faqs', ['category' => $cat]) }}" class="text-sm {{ $category === $cat ? 'font-medium text-stone-900 underline decoration-stone-900 underline-offset-4' : 'text-stone-500 hover:text-stone-900' }}">{{ $cat }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <div class="space-y-2">
            @forelse ($faqs as $faq)
                <details class="group border-b border-brand-900/10 py-4">
                    <summary class="cursor-pointer list-none text-sm font-medium text-stone-900 flex justify-between gap-4 items-start [&::-webkit-details-marker]:hidden">
                        {{ $faq->question }}
                        <span class="shrink-0 text-stone-400 text-lg leading-none group-open:rotate-45 transition">+</span>
                    </summary>
                    <div class="mt-3 text-sm text-stone-600 leading-relaxed pr-8">
                        {{ $faq->answer }}
                    </div>
                </details>
            @empty
                <p class="text-sm text-stone-500">No FAQs yet.</p>
            @endforelse
        </div>
    </div>
@endsection
