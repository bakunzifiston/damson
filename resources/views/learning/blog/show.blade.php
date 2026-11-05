@extends('layouts.site')

@section('title', $post->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-14">
        <nav aria-label="Breadcrumb" class="text-sm text-stone-500">
            <a href="{{ route('learning.resources', ['type' => 'article']) }}" class="transition hover:text-brand-900">← All resources</a>
        </nav>
        <header class="mt-6 border-b border-stone-200 pb-8">
            <time datetime="{{ ($post->published_at ?? $post->created_at)->toDateString() }}" class="text-xs font-medium uppercase tracking-wide text-damson-orange">{{ ($post->published_at ?? $post->created_at)->format('F j, Y') }}</time>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">{{ $post->title }}</h1>
            @if ($post->excerpt)<p class="mt-4 text-lg leading-relaxed text-stone-600">{{ $post->excerpt }}</p>@endif
        </header>
        <div class="damson-markdown mt-8 max-w-none text-stone-700">
            {!! Str::markdown($post->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>
    </article>
@endsection
