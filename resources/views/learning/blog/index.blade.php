@extends('layouts.site')

@section('title', 'Blog')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Blog</h1>
            <p class="mt-2 text-sm text-stone-500">Articles and updates.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div class="divide-y divide-brand-900/10 border-t border-brand-900/10">
            @forelse ($posts as $post)
                <article>
                    <a href="{{ route('learning.blog.show', $post) }}" class="block py-8 hover:text-stone-600">
                        <time class="text-xs uppercase tracking-wide text-stone-400">
                            {{ $post->published_at?->format('M j, Y') ?? $post->created_at->format('M j, Y') }}
                        </time>
                        <h2 class="mt-2 text-lg font-medium text-stone-900">{{ $post->title }}</h2>
                        <p class="mt-2 text-sm text-stone-500 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->body), 140) }}</p>
                    </a>
                </article>
            @empty
                <p class="py-8 text-sm text-stone-500">No articles yet.</p>
            @endforelse
        </div>
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
