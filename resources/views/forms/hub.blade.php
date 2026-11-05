@extends('layouts.site')

@section('title', 'Forms')

@section('content')
    @php
        $forms = [
            ['Purchases', 'Log interest in tubes, spawn, or DMMS hardware.', route('forms.purchase')],
            ['Sales', 'Record outbound sales for reporting.', route('forms.sales')],
            ['DMMS monitoring', 'Capture temperature, humidity and CO₂ readings.', route('forms.dmms')],
            ['Incubation', 'Track batches through to expected fruiting.', route('forms.incubation')],
        ];
    @endphp
    <section class="border-b border-stone-200 bg-brand-50/60">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">Forms</h1>
            <p class="mt-3 max-w-xl text-stone-600">
                Choose a form to submit. Staff can <a href="{{ route('login') }}" class="font-medium text-brand-900 underline decoration-brand-300 underline-offset-4 hover:decoration-brand-900">sign in</a> to the dashboard to review all records.
            </p>
        </div>
    </section>
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-12">
        <ul class="grid gap-4 sm:grid-cols-2">
            @foreach ($forms as [$name, $desc, $url])
                <li>
                    <a href="{{ $url }}" class="group flex h-full flex-col rounded-xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-brand-300 hover:shadow-md">
                        <h2 class="font-display text-lg font-semibold text-brand-950">{{ $name }}</h2>
                        <p class="mt-1.5 flex-1 text-sm text-stone-600">{{ $desc }}</p>
                        <span class="mt-4 text-sm font-medium text-brand-700 group-hover:text-damson-orange">Open form <span aria-hidden="true">→</span></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
