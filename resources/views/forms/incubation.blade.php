@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Incubation tracking')

@section('content')
    @php $hub = auth()->check(); @endphp
    <x-form-page :hub="$hub" title="Incubation" intro="Track batches from spawn run through expected fruiting."
                 :back-url="$hub ? route('data-hub.module', 'incubation') : route('forms.hub')"
                 :back-label="$hub ? 'Incubation list' : 'All forms'">
        <form action="{{ route('forms.incubation.store') }}" method="post" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="batch_reference" label="Batch reference" required />
                <x-field name="species" label="Species / strain" required />
                <x-field name="incubation_start" label="Incubation start" type="date" required />
                <x-field name="expected_fruit" label="Expected fruiting" type="date" optional />
            </div>
            <x-field name="phase" label="Phase" placeholder="Colonization, pinning, rest" optional />
            <x-field name="observations" label="Observations" type="textarea" optional />
            <button class="damson-btn w-full sm:w-auto" type="submit">Save</button>
        </form>
    </x-form-page>
@endsection
