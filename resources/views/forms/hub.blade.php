@extends('layouts.site')

@section('title', 'Forms')

@section('content')
    <div class="damson-page-hero">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-14">
            <h1 class="font-display text-3xl font-semibold text-stone-900">Forms</h1>
            <p class="mt-2 max-w-xl text-sm text-stone-500">
                Purchases, sales, DMMS logs, incubation. Staff: <a href="{{ route('login') }}" class="text-stone-900 underline decoration-stone-300 underline-offset-4">sign in</a> for the data hub.
            </p>
        </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <ul class="divide-y divide-brand-900/10 border-t border-brand-900/10">
            <li><a href="{{ route('forms.purchase') }}" class="block py-5 text-sm font-medium text-stone-900 hover:text-stone-600">Purchases</a></li>
            <li><a href="{{ route('forms.sales') }}" class="block py-5 text-sm font-medium text-stone-900 hover:text-stone-600">Sales</a></li>
            <li><a href="{{ route('forms.dmms') }}" class="block py-5 text-sm font-medium text-stone-900 hover:text-stone-600">DMMS monitoring</a></li>
            <li><a href="{{ route('forms.incubation') }}" class="block py-5 text-sm font-medium text-stone-900 hover:text-stone-600">Incubation</a></li>
        </ul>
    </div>
@endsection
