@extends('layouts.site')

@section('title', 'Guides')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Guides</h1>
            <p class="mt-2 text-sm text-stone-500">Step-by-step using DAMSON products.</p>
        </div>
    </div>
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <ul class="divide-y divide-brand-900/10 border-t border-brand-900/10">
            @forelse ($guides as $guide)
                <li>
                    <a href="{{ route('learning.guides.show', $guide) }}" class="block py-6 hover:text-stone-600">
                        <span class="text-xs uppercase tracking-wide text-stone-400">{{ $guide->difficulty }}</span>
                        <h2 class="mt-1 text-lg font-medium text-stone-900">{{ $guide->title }}</h2>
                        @if ($guide->excerpt)
                            <p class="mt-1 text-sm text-stone-500">{{ $guide->excerpt }}</p>
                        @endif
                    </a>
                </li>
            @empty
                <li class="py-8 text-sm text-stone-500">No guides yet.</li>
            @endforelse
        </ul>
    </div>
@endsection
