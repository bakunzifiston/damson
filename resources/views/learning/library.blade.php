@extends('layouts.site')

@section('title', 'Resource library')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Library</h1>
            <p class="mt-2 text-sm text-stone-500">Documents and links by category.</p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl space-y-14 px-4 py-12 sm:px-6">
        @forelse ($resources as $category => $items)
            <section>
                <h2 class="text-sm font-medium uppercase tracking-wide text-stone-400">{{ $category }}</h2>
                <ul class="mt-4 space-y-6 sm:grid sm:grid-cols-2 sm:gap-8 sm:space-y-0">
                    @foreach ($items as $res)
                        <li class="border-b border-brand-900/10 pb-6 sm:border-0 sm:pb-0">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="text-xs uppercase tracking-wide text-stone-400">{{ $res->resource_type }}</span>
                                    <h3 class="mt-1 font-semibold text-stone-900">{{ $res->title }}</h3>
                                    @if ($res->description)
                                        <p class="mt-2 text-sm text-stone-600">{{ $res->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                @if ($res->external_url)
                                    <a href="{{ $res->external_url }}" class="text-sm font-medium text-stone-900 underline decoration-stone-300 underline-offset-4 hover:decoration-stone-900" rel="noopener noreferrer" target="_blank">Open</a>
                                @elseif ($res->file_path)
                                    <a href="{{ Storage::url($res->file_path) }}" class="text-sm font-medium text-stone-900 underline decoration-stone-300 underline-offset-4 hover:decoration-stone-900" download>Download</a>
                                @else
                                    <span class="text-xs text-stone-400">No file linked — add path in admin.</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        @empty
            <p class="text-center text-stone-500">No library items yet.</p>
        @endforelse
    </div>
@endsection
