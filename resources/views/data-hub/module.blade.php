@extends('layouts.dashboard')

@section('title', $meta['title'])

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header :title="$meta['title']" :subtitle="$meta['subtitle']" :crumbs="[['label' => $meta['title']]]">
            <x-slot:actions>
                <a href="{{ route($meta['add_route']) }}" class="damson-btn-accent">{{ $meta['add_label'] }}</a>
            </x-slot:actions>
        </x-dash-header>

        <div class="dashboard-card mt-6 overflow-hidden">
            <x-list-toolbar placeholder="Search {{ strtolower($meta['title']) }}…" :export-url="route('data-hub.module.export', ['module' => $module] + request()->only(['q', 'payment_status', 'alerts', 'sort', 'dir']))">
                @if ($module === 'sales')
                    <div>
                        <label for="payment_status" class="sr-only">Payment status</label>
                        <select id="payment_status" name="payment_status" class="damson-input !mt-0">
                            <option value="">All payments</option>
                            @foreach (['pending' => 'Pending', 'partial' => 'Partial', 'paid' => 'Paid'] as $v => $l)
                                <option value="{{ $v }}" @selected(request('payment_status') === $v)>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($module === 'dmms')
                    <label class="flex items-center gap-2 text-sm text-stone-700">
                        <input type="checkbox" name="alerts" value="1" class="h-4 w-4 rounded border-stone-300" @checked(request()->boolean('alerts'))>
                        Only readings with alerts
                    </label>
                @endif
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            @foreach ($meta['columns'] as $col)
                                <x-sort-th :column="$col" :label="str_replace('_', ' ', $col)" :sort="$sort" :dir="$dir" :right="$col === 'amount'" />
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
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
                                    <td class="max-w-xs truncate {{ $col === 'amount' ? 'is-right tabular-nums' : '' }}" @if (is_string($val) && strlen($val) > 30) title="{{ $val }}" @endif>
                                        @if ($col === 'payment_status' && $val)
                                            <x-status-badge :status="$val" />
                                        @else
                                            {{ $val ?? '—' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($meta['columns']) }}">
                                    @if (request()->hasAny(['q', 'payment_status', 'alerts']))
                                        <x-empty-state title="No matching records" text="Try a different search or reset the filters." />
                                    @else
                                        <x-empty-state title="No records yet" text="Use the button above to create the first one." />
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($rows->hasPages())
                <div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $rows->links() }}</div>
            @endif
        </div>
    </div>
@endsection
