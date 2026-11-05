@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'DMMS monitoring')

@section('content')
    @php $hub = auth()->check(); @endphp
    <x-form-page :hub="$hub" title="DMMS log" intro="Record environmental readings linked to farm zones for the dashboard history."
                 :back-url="$hub ? route('data-hub.module', 'dmms') : route('forms.hub')"
                 :back-label="$hub ? 'DMMS list' : 'All forms'">
        <form action="{{ route('forms.dmms.store') }}" method="post" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="farm_name" label="Farm name" required />
                <x-field name="zone" label="Zone / room" placeholder="Fruiting A, Incubation 2" optional />
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <x-field name="temperature_c" label="Temperature (°C)" type="number" step="0.1" optional />
                <x-field name="humidity_pct" label="Humidity (RH %)" type="number" step="0.1" optional />
                <x-field name="co2_ppm" label="CO₂ (ppm)" type="number" optional />
            </div>
            <x-field name="recorded_at" label="Recorded at" type="datetime-local" :value="now()->format('Y-m-d\TH:i')" required />
            <x-field name="alert_message" label="Alert" placeholder="Threshold breach description" optional />
            <x-field name="notes" label="Notes" type="textarea" :rows="2" optional />
            <button class="damson-btn w-full sm:w-auto" type="submit">Save</button>
        </form>
    </x-form-page>
@endsection
