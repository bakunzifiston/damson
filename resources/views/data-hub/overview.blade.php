@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    @php
        $sym = config('app.currency_symbol', '$');
        $firstName = strtok(auth()->user()->name, ' ') ?: auth()->user()->name;
        $statLabels = ['purchases' => 'Purchase inquiries', 'sales' => 'Sales records', 'dmms' => 'DMMS readings', 'incubation' => 'Incubation batches', 'contacts' => 'Messages'];

        $kpis = [
            ['Revenue', $sym.number_format($revenue, 2), 'Excludes cancelled orders', route('data-hub.orders.index')],
            ['Open orders', number_format($openOrders), 'Pending or processing', route('data-hub.orders.index', ['status' => 'pending'])],
            ['Total orders', number_format($orderCount), 'All time', route('data-hub.orders.index')],
            ['Low-stock products', number_format($lowStockCount), 'Active, '.$lowStockThreshold.' or fewer left', route('data-hub.products.index', ['low_stock' => 1])],
        ];

        $records = [];
        foreach ($counts as $key => $n) {
            $records[] = [$statLabels[$key] ?? ucfirst($key), $n, route('data-hub.module', $key)];
        }
        array_unshift($records, ['Products', $productCount, route('data-hub.products.index')]);

        $maxOrders = max(1, max(array_column($series, 'orders')));
        $chartOrders = array_sum(array_column($series, 'orders'));
        $quick = [
            ['Add product', route('data-hub.products.create')],
            ['Log a sale', route('forms.sales')],
            ['Log a purchase', route('forms.purchase')],
            ['Record DMMS reading', route('forms.dmms')],
            ['Track incubation batch', route('forms.incubation')],
            ['Add message', route('data-hub.contacts.create')],
        ];
    @endphp

    <div class="mx-auto max-w-6xl space-y-8">
        <x-dash-header :title="'Welcome back, '.$firstName" subtitle="Live figures from your orders, inventory and farm records." />

        {{-- KPIs --}}
        <ul class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Key figures">
            @foreach ($kpis as [$label, $value, $hint, $url])
                <li>
                    <a href="{{ $url }}" class="stat-link group h-full">
                        <p class="text-sm font-medium text-stone-500">{{ $label }}</p>
                        <p class="mt-2 font-display text-3xl font-semibold tabular-nums text-brand-950">{{ $value }}</p>
                        <p class="mt-1 text-xs text-stone-500">{{ $hint }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Orders chart --}}
            <section class="dashboard-card p-6 lg:col-span-2" aria-labelledby="chart-title">
                <div class="flex items-baseline justify-between gap-3">
                    <h2 id="chart-title" class="text-sm font-semibold text-stone-900">Orders, last 14 days</h2>
                    <p class="text-xs text-stone-500">{{ number_format($chartOrders) }} {{ Str::plural('order', $chartOrders) }} (excl. cancelled)</p>
                </div>
                @if ($chartOrders === 0)
                    <p class="mt-8 rounded-lg bg-stone-50 px-4 py-10 text-center text-sm text-stone-500">No orders in the last 14 days.</p>
                @else
                    <div class="mt-6 flex h-48 items-end gap-1.5 sm:gap-2" role="img" aria-label="Bar chart of orders per day for the last 14 days">
                        @foreach ($series as $day)
                            <div class="group relative flex h-full min-w-0 flex-1 flex-col justify-end" title="{{ $day['label'] }}: {{ $day['orders'] }} {{ Str::plural('order', $day['orders']) }}, {{ $sym }}{{ number_format($day['revenue'], 2) }}">
                                <div class="w-full rounded-t bg-brand-700 transition group-hover:bg-damson-orange {{ $day['orders'] === 0 ? 'opacity-20' : '' }}" style="height: {{ $day['orders'] === 0 ? 2 : max(4, round($day['orders'] / $maxOrders * 100)) }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex justify-between text-[11px] text-stone-500" aria-hidden="true">
                        <span>{{ $series[0]['label'] }}</span><span>{{ $series[13]['label'] }}</span>
                    </div>
                    <table class="sr-only">
                        <caption>Orders per day</caption>
                        <thead><tr><th>Day</th><th>Orders</th><th>Revenue</th></tr></thead>
                        <tbody>@foreach ($series as $day)<tr><td>{{ $day['label'] }}</td><td>{{ $day['orders'] }}</td><td>{{ $sym }}{{ number_format($day['revenue'], 2) }}</td></tr>@endforeach</tbody>
                    </table>
                @endif
            </section>

            {{-- Low stock --}}
            <section class="dashboard-card p-6" aria-labelledby="stock-title">
                <div class="flex items-baseline justify-between gap-3">
                    <h2 id="stock-title" class="text-sm font-semibold text-stone-900">Needs restocking</h2>
                    <a href="{{ route('data-hub.products.index', ['low_stock' => 1]) }}" class="text-xs font-medium text-brand-700 hover:text-damson-orange">View all</a>
                </div>
                @forelse ($lowStock as $p)
                    <a href="{{ route('data-hub.products.edit', $p->id) }}" class="mt-3 flex items-center justify-between gap-3 rounded-lg px-2 py-2 text-sm first:mt-4 hover:bg-stone-50">
                        <span class="min-w-0 truncate font-medium text-stone-800">{{ $p->name }}</span>
                        <span class="badge {{ $p->stock === 0 ? 'badge-danger' : 'badge-warning' }}">{{ $p->stock === 0 ? 'Out of stock' : $p->stock.' left' }}</span>
                    </a>
                @empty
                    <p class="mt-4 text-sm text-stone-500">All active products are well stocked.</p>
                @endforelse
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Recent orders --}}
            <section class="dashboard-card overflow-hidden lg:col-span-2" aria-labelledby="recent-title">
                <div class="flex items-baseline justify-between gap-3 border-b border-stone-200 px-6 py-4">
                    <h2 id="recent-title" class="text-sm font-semibold text-stone-900">Recent orders</h2>
                    <a href="{{ route('data-hub.orders.index') }}" class="text-xs font-medium text-brand-700 hover:text-damson-orange">View all</a>
                </div>
                @if ($recentOrders->isEmpty())
                    <x-empty-state title="No orders yet" text="Store orders will appear here." />
                @else
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead><tr><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Status</th><th scope="col" class="is-right">Total</th></tr></thead>
                            <tbody>
                                @foreach ($recentOrders as $o)
                                    <tr>
                                        <td class="whitespace-nowrap"><a href="{{ route('data-hub.orders.show', $o) }}" class="font-mono text-xs font-semibold text-brand-900 hover:text-damson-orange">{{ $o->order_number }}</a></td>
                                        <td class="max-w-[14rem] truncate">{{ $o->customer_name }}</td>
                                        <td><x-status-badge :status="$o->status" :label="$o->status_label" /></td>
                                        <td class="is-right whitespace-nowrap tabular-nums">{{ $sym }}{{ number_format((float) $o->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- DMMS alerts --}}
            <section class="dashboard-card p-6" aria-labelledby="alerts-title">
                <div class="flex items-baseline justify-between gap-3">
                    <h2 id="alerts-title" class="text-sm font-semibold text-stone-900">Recent DMMS alerts</h2>
                    <a href="{{ route('data-hub.module', ['module' => 'dmms', 'alerts' => 1]) }}" class="text-xs font-medium text-brand-700 hover:text-damson-orange">View all</a>
                </div>
                @forelse ($recentAlerts as $a)
                    <div class="mt-4 border-l-2 border-damson-orange pl-3 text-sm">
                        <p class="font-medium text-stone-800">{{ $a->alert_message }}</p>
                        <p class="mt-0.5 text-xs text-stone-500">{{ $a->farm_name }}@if ($a->zone) · {{ $a->zone }}@endif · {{ $a->recorded_at?->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="mt-4 text-sm text-stone-500">No alerts recorded.</p>
                @endforelse
            </section>
        </div>

        {{-- Records --}}
        <section aria-labelledby="records-title">
            <h2 id="records-title" class="text-sm font-semibold uppercase tracking-wide text-stone-500">Records</h2>
            <ul class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                @foreach ($records as [$label, $n, $url])
                    <li>
                        <a href="{{ $url }}" class="stat-link group !p-4">
                            <p class="text-xs font-medium text-stone-500">{{ $label }}</p>
                            <p class="mt-1 font-display text-2xl font-semibold tabular-nums text-brand-950">{{ number_format($n) }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section aria-labelledby="quick-actions">
            <h2 id="quick-actions" class="text-sm font-semibold uppercase tracking-wide text-stone-500">Quick actions</h2>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($quick as [$label, $url])
                    <a href="{{ $url }}" class="damson-btn-outline">{{ $label }}</a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
