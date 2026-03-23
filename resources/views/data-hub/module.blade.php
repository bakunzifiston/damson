@extends('layouts.dashboard')

@section('title', $meta['title'])

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">
                    <a href="{{ route('data-hub.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Overview</a>
                    <span class="text-stone-300">/</span>
                    Module
                </p>
                <h1 class="mt-1 font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">{{ $meta['title'] }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-stone-600">{{ $meta['subtitle'] }}</p>
            </div>
            <a href="{{ route($meta['add_route']) }}" class="damson-btn-accent shrink-0 rounded-xl px-6 shadow-md">{{ $meta['add_label'] }}</a>
        </div>

        <div class="dashboard-card mt-8 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-sm">
                    <thead class="bg-brand-50/90">
                        <tr>
                            @foreach ($meta['columns'] as $col)
                                <th scope="col" class="whitespace-nowrap px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">
                                    {{ str_replace('_', ' ', $col) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($rows as $row)
                            <tr class="hover:bg-brand-50/40">
                                @foreach ($meta['columns'] as $col)
                                    @php
                                        $val = data_get($row, $col);
                                        if ($val instanceof \Carbon\CarbonInterface) {
                                            $val = $val->format('M j, Y g:i a');
                                        }
                                        if ($col === 'message' && is_string($val)) {
                                            $val = Str::limit($val, 72);
                                        }
                                        if ($col === 'amount' && $val !== null && $val !== '') {
                                            $val = number_format((float) $val, 2);
                                        }
                                    @endphp
                                    <td class="max-w-xs truncate px-4 py-2.5 text-stone-700">{{ $val ?? '—' }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($meta['columns']) }}" class="px-4 py-16 text-center text-sm text-stone-500">
                                    No records yet. Use <strong class="text-brand-950">{{ $meta['add_label'] }}</strong> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($rows->hasPages())
                <div class="border-t border-stone-100 bg-stone-50/80 px-4 py-3">
                    {{ $rows->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
