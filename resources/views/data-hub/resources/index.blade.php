@extends('layouts.dashboard')

@section('title', 'Resources')

@section('content')
    @php
        $tabs = ['' => 'All'] + \App\Models\LearningItem::TYPES;
        $typeBadge = ['article' => 'badge-neutral', 'guide' => 'badge-warning', 'download' => 'badge-info'];
    @endphp
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="Resources" subtitle="Articles, guides and downloads shown on the public Learning page." :crumbs="[['label' => 'Resources']]">
            <x-slot:actions>
                <a href="{{ route('data-hub.resources.create', array_filter(['type' => $type])) }}" class="damson-btn-accent">Add resource</a>
            </x-slot:actions>
        </x-dash-header>

        <div class="mt-6 flex flex-wrap gap-2" role="group" aria-label="Filter by type">
            @foreach ($tabs as $key => $label)
                @php $active = ($type ?? '') === $key; @endphp
                <a href="{{ route('data-hub.resources.index', array_filter(['type' => $key, 'q' => request('q')])) }}" @if ($active) aria-current="true" @endif
                   class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition {{ $active ? 'border-brand-900 bg-brand-900 text-white' : 'border-stone-300 bg-white text-stone-700 hover:border-brand-900' }}">
                    {{ $label }} <span class="{{ $active ? 'text-white/70' : 'text-stone-400' }}">{{ $key === '' ? $counts->sum() : ($counts[$key] ?? 0) }}</span>
                </a>
            @endforeach
        </div>

        <div class="dashboard-card mt-4 overflow-hidden">
            <x-list-toolbar placeholder="Search title, summary or category…">
                @if ($type)<input type="hidden" name="type" value="{{ $type }}">@endif
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="title" label="Title" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="type" label="Type" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="category" label="Category" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="is_published" label="Status" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="updated_at" label="Updated" :sort="$sort" :dir="$dir" />
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td class="max-w-sm font-medium text-stone-900"><span class="line-clamp-2">{{ $item->title }}</span></td>
                                <td class="whitespace-nowrap">
                                    <span class="badge {{ $typeBadge[$item->type] ?? 'badge-neutral' }}">{{ $item->type_label }}</span>
                                    @if ($item->type === 'guide' && $item->difficulty)<span class="ml-1 text-xs text-stone-500">{{ ucfirst($item->difficulty) }}</span>@endif
                                    @if ($item->type === 'download' && $item->format)<span class="ml-1 text-xs text-stone-500">{{ $item->format }}</span>@endif
                                </td>
                                <td class="whitespace-nowrap">{{ $item->category ?? '—' }}</td>
                                <td class="whitespace-nowrap">
                                    @if (! $item->is_published)<span class="badge badge-neutral">Draft</span>
                                    @elseif ($item->published_at && $item->published_at->isFuture())<span class="badge badge-info">Scheduled</span>
                                    @else<span class="badge badge-success">Published</span>@endif
                                </td>
                                <td class="whitespace-nowrap text-stone-600">{{ $item->updated_at?->format('M j, Y') }}</td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.resources.edit', $item) }}" class="damson-btn-outline damson-btn-sm">Edit<span class="sr-only"> {{ $item->title }}</span></a>
                                    <form action="{{ route('data-hub.resources.destroy', $item) }}" method="post" class="ml-1 inline" onsubmit="return confirm('Delete this {{ strtolower($item->type_label) }}? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="damson-btn-danger damson-btn-sm">Delete<span class="sr-only"> {{ $item->title }}</span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">
                                @if (request()->hasAny(['q', 'type']))
                                    <x-empty-state title="No matching resources" text="Try a different search or filter." />
                                @else
                                    <x-empty-state title="No resources yet" text="Add the first article, guide or download.">
                                        <a href="{{ route('data-hub.resources.create') }}" class="damson-btn-accent">Add resource</a>
                                    </x-empty-state>
                                @endif
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($items->hasPages())<div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $items->links() }}</div>@endif
        </div>
    </div>
@endsection
