@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'DMMS monitoring')

@section('content')
    @php
        $hub = auth()->check();
    @endphp
    <div class="mx-auto max-w-2xl @unless($hub) px-4 py-12 sm:px-6 lg:px-8 @endunless">
        <a href="{{ $hub ? route('data-hub.module', ['module' => 'dmms']) : route('forms.hub') }}" class="text-sm font-medium {{ $hub ? 'text-damson-orange hover:text-damson-orange-hover' : 'text-stone-500 hover:text-stone-900' }}">← {{ $hub ? 'DMMS list' : 'Forms' }}</a>
        <div class="mt-6 {{ $hub ? 'dashboard-card p-6 sm:p-8' : 'rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm sm:p-8' }}">
            <h1 class="font-display text-xl font-semibold text-stone-900">DMMS log</h1>
            <p class="mt-2 text-sm text-stone-600">Record environmental readings linked to farm zones for the dashboard history.</p>
            <form action="{{ route('forms.dmms.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="farm_name">Farm name</label>
                    <input class="damson-input" type="text" name="farm_name" id="farm_name" value="{{ old('farm_name') }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="zone">Zone / room</label>
                    <input class="damson-input" type="text" name="zone" id="zone" value="{{ old('zone') }}" placeholder="Fruiting A, Incubation 2">
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="temperature_c">°C</label>
                        <input class="damson-input" type="number" step="0.1" name="temperature_c" id="temperature_c" value="{{ old('temperature_c') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="humidity_pct">RH %</label>
                        <input class="damson-input" type="number" step="0.1" name="humidity_pct" id="humidity_pct" value="{{ old('humidity_pct') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="co2_ppm">CO₂ ppm</label>
                        <input class="damson-input" type="number" name="co2_ppm" id="co2_ppm" value="{{ old('co2_ppm') }}">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="recorded_at">Recorded at</label>
                    <input class="damson-input" type="datetime-local" name="recorded_at" id="recorded_at" value="{{ old('recorded_at', now()->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="alert_message">Alert (optional)</label>
                    <input class="damson-input" type="text" name="alert_message" id="alert_message" value="{{ old('alert_message') }}" placeholder="Threshold breach description">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="notes">Notes</label>
                    <textarea class="damson-input" name="notes" id="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
                <button class="damson-btn w-full" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
