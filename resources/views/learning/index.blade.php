@extends('layouts.site')

@section('title', 'Learning')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Learning</h1>
            <p class="mt-2 text-sm text-stone-500 sm:text-base">Blog, guides, FAQs, library.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
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
    </div>
@endsection
