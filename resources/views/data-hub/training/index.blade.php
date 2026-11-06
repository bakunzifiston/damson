@extends('layouts.dashboard')

@section('title', 'Training applications')

@section('content')
    @php
        $modes = \App\Models\TrainingApplication::MODES;
        $statuses = \App\Models\TrainingApplication::STATUSES;
    @endphp
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="Training applications" subtitle="People who applied for mushroom farming training on the website." :crumbs="[['label' => 'Training applications']]" />

        <div class="mt-6 flex flex-wrap gap-2" role="group" aria-label="Filter by status">
            @foreach (['' => 'All'] + $statuses as $key => $label)
                @php $active = (request('status') ?? '') === $key; @endphp
                <a href="{{ route('data-hub.training.index', array_merge(request()->except(['status', 'page']), array_filter(['status' => $key]))) }}" @if ($active) aria-current="true" @endif
                   class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition {{ $active ? 'border-brand-900 bg-brand-900 text-white' : 'border-stone-300 bg-white text-stone-700 hover:border-brand-900' }}">
                    {{ $label }} <span class="{{ $active ? 'text-white/70' : 'text-stone-400' }}">{{ $key === '' ? $statusCounts->sum() : ($statusCounts[$key] ?? 0) }}</span>
                </a>
            @endforeach
        </div>

        <div class="dashboard-card mt-4 overflow-hidden">
            <x-list-toolbar placeholder="Search name, phone or email…">
                @if (request()->filled('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <div>
                    <label for="mode" class="sr-only">Training mode</label>
                    <select id="mode" name="mode" class="damson-input !mt-0">
                        <option value="">All training modes</option>
                        @foreach ($modes as $key => $label)<option value="{{ $key }}" @selected(request('mode') === $key)>{{ Str::before($label, ' (') }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label for="interest" class="sr-only">Training interest</label>
                    <select id="interest" name="interest" class="damson-input !mt-0 sm:max-w-[16rem]">
                        <option value="">All interests</option>
                        @foreach (\App\Models\TrainingApplication::INTERESTS as $label)<option value="{{ $label }}" @selected(request('interest') === $label)>{{ $label }}</option>@endforeach
                    </select>
                </div>
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="created_at" label="Submitted" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="full_name" label="Applicant" :sort="$sort" :dir="$dir" />
                            <th scope="col">Phone</th>
                            <x-sort-th column="training_mode" label="Mode" :sort="$sort" :dir="$dir" />
                            <th scope="col">Interests</th>
                            <x-sort-th column="status" label="Status" :sort="$sort" :dir="$dir" />
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $a)
                            <tr>
                                <td class="whitespace-nowrap text-stone-600">{{ $a->created_at->format('M j, Y g:i a') }}</td>
                                <td class="max-w-[14rem]">
                                    <a href="{{ route('data-hub.training.show', $a) }}" class="block truncate font-medium text-stone-900 hover:text-brand-700">{{ $a->full_name }}</a>
                                    <span class="block truncate text-xs text-stone-500">{{ $a->email }}</span>
                                </td>
                                <td class="whitespace-nowrap">{{ $a->phone }}</td>
                                <td class="whitespace-nowrap"><span class="badge badge-neutral">{{ Str::before($a->mode_label, ' (') }}</span></td>
                                <td class="max-w-[16rem]" title="{{ implode(', ', $a->interests) }}">
                                    <span class="line-clamp-2 text-xs text-stone-600">{{ implode(', ', $a->interests) }}</span>
                                </td>
                                <td class="whitespace-nowrap"><x-status-badge :status="$a->status" :label="$a->status_label" /></td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.training.show', $a) }}" class="damson-btn-outline damson-btn-sm">View<span class="sr-only"> application from {{ $a->full_name }}</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">
                                @if (request()->hasAny(['q', 'mode', 'interest', 'status']))
                                    <x-empty-state title="No matching applications" text="Try a different search or reset the filters." />
                                @else
                                    <x-empty-state title="No applications yet" text="Applications submitted on the website will appear here." />
                                @endif
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($applications->hasPages())<div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $applications->links() }}</div>@endif
        </div>
    </div>
@endsection
