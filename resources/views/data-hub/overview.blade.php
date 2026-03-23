@extends('layouts.dashboard')

@section('title', 'Overview')

@section('content')
    @php
        $statLabels = [
            'purchases' => 'Purchases',
            'sales' => 'Sales',
            'dmms' => 'DMMS',
            'incubation' => 'Incubation',
            'contacts' => 'Messages',
        ];
    @endphp

    <div class="mx-auto max-w-6xl">
        <div>
            <p class="text-sm font-medium text-stone-500">Overview</p>
            <h1 class="mt-1 font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">
                Welcome, {{ strtok(auth()->user()->name, ' ') ?: auth()->user()->name }}
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-stone-600">Choose a module in the sidebar to view and add records.</p>
        </div>

        <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" aria-label="Record totals">
            <li>
                <a href="{{ route('data-hub.products.index') }}" class="dashboard-card block p-5 transition hover:border-damson-orange/30 hover:shadow-md">
                    <p class="text-xs font-medium uppercase tracking-wide text-stone-500">Products</p>
                    <p class="mt-2 font-display text-2xl font-semibold text-brand-950">{{ number_format($productCount) }}</p>
                    <p class="mt-2 text-xs font-semibold text-damson-orange">Catalog →</p>
                </a>
            </li>
            <li>
                <a href="{{ route('data-hub.orders.index') }}" class="dashboard-card block p-5 transition hover:border-damson-orange/30 hover:shadow-md">
                    <p class="text-xs font-medium uppercase tracking-wide text-stone-500">Store orders</p>
                    <p class="mt-2 font-display text-2xl font-semibold text-brand-950">{{ number_format($orderCount) }}</p>
                    <p class="mt-2 text-xs font-semibold text-damson-orange">View orders →</p>
                </a>
            </li>
            @foreach ($counts as $key => $n)
                <li>
                    <a href="{{ route('data-hub.module', ['module' => $key]) }}" class="dashboard-card block p-5 transition hover:border-damson-orange/30 hover:shadow-md">
                        <p class="text-xs font-medium uppercase tracking-wide text-stone-500">{{ $statLabels[$key] ?? $key }}</p>
                        <p class="mt-2 font-display text-2xl font-semibold text-brand-950">{{ number_format($n) }}</p>
                        <p class="mt-2 text-xs font-semibold text-damson-orange">Open list →</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
