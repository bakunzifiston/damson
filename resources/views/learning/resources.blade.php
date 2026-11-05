@extends('layouts.site')

@section('title', 'Resources')

@section('content')
    @php
        $tabs = ['' => 'All'] + \App\Models\LearningItem::TYPES;
        $badge = ['beginner' => 'badge-success', 'intermediate' => 'badge-warning', 'advanced' => 'badge-danger'];
    @endphp
    <x-simple-hero title="Resources" subtitle="Articles, step-by-step guides and downloads to help you grow.">
        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2" role="group" aria-label="Filter by type">
                @foreach ($tabs as $key => $label)
                    @php $active = ($type ?? '') === $key; @endphp
                    <a href="{{ route('learning.resources', array_filter(['type' => $key, 'q' => $term])) }}" @if ($active) aria-current="true" @endif
                       class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition {{ $active ? 'border-brand-900 bg-brand-900 text-white' : 'border-stone-300 bg-white text-stone-700 hover:border-brand-900' }}">
                        {{ $label }} <span class="{{ $active ? 'text-white/70' : 'text-stone-400' }}">{{ $key === '' ? $counts->sum() : ($counts[$key] ?? 0) }}</span>
                    </a>
                @endforeach
            </div>
            <form method="get" action="{{ route('learning.resources') }}" role="search" class="flex gap-2">
                @if ($type)<input type="hidden" name="type" value="{{ $type }}">@endif
                @if ($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                <label for="q" class="sr-only">Search resources</label>
                <input id="q" type="search" name="q" value="{{ $term }}" placeholder="Search…" maxlength="100" class="damson-input !mt-0 sm:w-56">
                <button type="submit" class="damson-btn">Search</button>
            </form>
        </div>
        @if ($type === 'download' && $downloadCategories->isNotEmpty())
            <div class="mt-4 border-t border-stone-200 pt-4">
                <x-learning.category-tabs :categories="$downloadCategories" :active="$category" />
            </div>
        @endif
    </x-simple-hero>

    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
        <ul class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($items as $item)
                <li>
                    @if ($item->type === 'download')
                        <x-learning.download-card :item="$item" />
                    @else
                        @php $isGuide = $item->type === 'guide'; @endphp
                        <a href="{{ $isGuide ? route('learning.guides.show', $item) : route('learning.blog.show', $item) }}" class="group flex h-full flex-col rounded-xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-brand-300 hover:shadow-md">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="badge {{ $isGuide ? 'badge-warning' : 'badge-neutral' }}">{{ $isGuide ? 'Guide' : 'Article' }}</span>
                                @if ($isGuide)<span class="badge {{ $badge[$item->difficulty] ?? 'badge-neutral' }}">{{ ucfirst($item->difficulty) }}</span>
                                @else<time datetime="{{ ($item->published_at ?? $item->created_at)->toDateString() }}" class="text-xs text-stone-500">{{ ($item->published_at ?? $item->created_at)->format('M j, Y') }}</time>@endif
                            </div>
                            <h2 class="mt-3 font-display text-lg font-semibold text-brand-950 group-hover:text-brand-700">{{ $item->title }}</h2>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm text-stone-600">{{ $item->excerpt ?? Str::limit(strip_tags((string) $item->body), 140) }}</p>
                            <span class="mt-4 text-sm font-medium text-brand-700 group-hover:text-damson-orange">{{ $isGuide ? 'Read guide' : 'Read article' }} <span aria-hidden="true">→</span></span>
                        </a>
                    @endif
                </li>
            @empty
                <li class="col-span-full rounded-xl border border-dashed border-stone-300 py-16 text-center text-sm text-stone-500">
                    {{ $term !== '' ? 'No resources match your search.' : 'No resources yet — check back soon.' }}
                </li>
            @endforelse
        </ul>
        <div class="mt-10">{{ $items->links() }}</div>
    </div>
@endsection
