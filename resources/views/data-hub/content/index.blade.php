@extends('layouts.dashboard')

@section('title', 'FAQs')

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="FAQs" subtitle="Questions and answers shown on the public FAQ page." :crumbs="[['label' => 'FAQs']]">
            <x-slot:actions>
                <a href="{{ route('data-hub.content.create') }}" class="damson-btn-accent">Add FAQ</a>
            </x-slot:actions>
        </x-dash-header>

        <div class="dashboard-card mt-6 overflow-hidden">
            <x-list-toolbar placeholder="Search questions, answers or category…" />
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="question" label="Question" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="category" label="Category" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="sort_order" label="Order" :sort="$sort" :dir="$dir" right />
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $faq)
                            <tr>
                                <td class="max-w-md font-medium text-stone-900"><span class="line-clamp-2">{{ $faq->question }}</span></td>
                                <td class="whitespace-nowrap">{{ $faq->category ?? '—' }}</td>
                                <td class="is-right tabular-nums">{{ $faq->sort_order }}</td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.content.edit', $faq) }}" class="damson-btn-outline damson-btn-sm">Edit<span class="sr-only"> {{ $faq->question }}</span></a>
                                    <form action="{{ route('data-hub.content.destroy', $faq) }}" method="post" class="ml-1 inline" onsubmit="return confirm('Delete this FAQ? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="damson-btn-danger damson-btn-sm">Delete<span class="sr-only"> {{ $faq->question }}</span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">
                                @if (request()->filled('q'))<x-empty-state title="No matches" text="Try a different search." />
                                @else<x-empty-state title="No FAQs yet" text="Add the first one to show it on the website."><a href="{{ route('data-hub.content.create') }}" class="damson-btn-accent">Add FAQ</a></x-empty-state>@endif
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($items->hasPages())<div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $items->links() }}</div>@endif
        </div>
    </div>
@endsection
