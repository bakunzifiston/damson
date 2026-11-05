@extends('layouts.site')

@section('title', $guide->title)

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-14">
        <nav aria-label="Breadcrumb" class="text-sm text-stone-500">
            <a href="{{ route('learning.resources', ['type' => 'guide']) }}" class="transition hover:text-brand-900">← All resources</a>
        </nav>
        <header class="mt-6 border-b border-stone-200 pb-8">
            <span class="badge {{ ['beginner' => 'badge-success', 'intermediate' => 'badge-warning', 'advanced' => 'badge-danger'][$guide->difficulty] ?? 'badge-neutral' }}">{{ ucfirst($guide->difficulty) }}</span>
            <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">{{ $guide->title }}</h1>
            @if ($guide->excerpt)<p class="mt-4 text-lg leading-relaxed text-stone-600">{{ $guide->excerpt }}</p>@endif
        </header>
        <div class="damson-markdown mt-8 max-w-none text-stone-700">
            {!! Str::markdown($guide->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>
    </article>
@endsection
