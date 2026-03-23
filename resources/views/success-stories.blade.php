@extends('layouts.site')

@section('title', 'Stories')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Success stories</h1>
            <p class="mt-2 text-sm text-stone-500">Testimonials from growers.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div class="space-y-16">
            @forelse ($stories as $story)
                <article class="max-w-2xl">
                    @if ($story->headline)
                        <p class="text-xs uppercase tracking-wide text-stone-400">{{ $story->headline }}</p>
                    @endif
                    <blockquote class="mt-2 text-stone-600 leading-relaxed">&ldquo;{{ $story->quote }}&rdquo;</blockquote>
                    <footer class="mt-4 text-sm text-stone-900">{{ $story->name }}@if ($story->location)<span class="text-stone-400"> · {{ $story->location }}</span>@endif</footer>
                </article>
            @empty
                <p class="text-sm text-stone-500">No stories yet.</p>
            @endforelse
        </div>
    </div>
@endsection
