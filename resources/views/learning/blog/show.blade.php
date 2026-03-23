@extends('layouts.site')

@section('title', $post->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
        <a href="{{ route('learning.blog.index') }}" class="text-sm text-stone-500 hover:text-stone-900">← Blog</a>
        <header class="mt-8">
            <time class="text-xs uppercase tracking-wide text-stone-400">{{ $post->published_at?->format('F j, Y') ?? $post->created_at->format('F j, Y') }}</time>
            <h1 class="mt-2 font-display text-3xl font-semibold text-stone-900">{{ $post->title }}</h1>
            @if ($post->excerpt)
                <p class="mt-4 text-lg text-stone-600 leading-relaxed">{{ $post->excerpt }}</p>
            @endif
        </header>
        <div class="damson-markdown mt-10 max-w-none text-stone-700">
            {!! Str::markdown($post->body) !!}
        </div>
    </article>
@endsection
