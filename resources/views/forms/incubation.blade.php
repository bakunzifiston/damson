@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Incubation tracking')

@section('content')
    @php
        $hub = auth()->check();
    @endphp
    <div class="mx-auto max-w-2xl @unless($hub) px-4 py-12 sm:px-6 lg:px-8 @endunless">
        <a href="{{ $hub ? route('data-hub.module', ['module' => 'incubation']) : route('forms.hub') }}" class="text-sm font-medium {{ $hub ? 'text-damson-orange hover:text-damson-orange-hover' : 'text-stone-500 hover:text-stone-900' }}">← {{ $hub ? 'Incubation list' : 'Forms' }}</a>
        <div class="mt-6 {{ $hub ? 'dashboard-card p-6 sm:p-8' : 'rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm sm:p-8' }}">
            <h1 class="font-display text-xl font-semibold text-stone-900">Incubation</h1>
            <p class="mt-2 text-sm text-stone-600">Track batches from spawn run through expected fruiting.</p>
            <form action="{{ route('forms.incubation.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="batch_reference">Batch reference</label>
                    <input class="damson-input" type="text" name="batch_reference" id="batch_reference" value="{{ old('batch_reference') }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="species">Species / strain</label>
                    <input class="damson-input" type="text" name="species" id="species" value="{{ old('species') }}" required>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="incubation_start">Incubation start</label>
                        <input class="damson-input" type="date" name="incubation_start" id="incubation_start" value="{{ old('incubation_start') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="expected_fruit">Expected fruiting</label>
                        <input class="damson-input" type="date" name="expected_fruit" id="expected_fruit" value="{{ old('expected_fruit') }}">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="phase">Phase</label>
                    <input class="damson-input" type="text" name="phase" id="phase" value="{{ old('phase') }}" placeholder="Colonization, pinning, rest">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="observations">Observations</label>
                    <textarea class="damson-input" name="observations" id="observations" rows="3">{{ old('observations') }}</textarea>
                </div>
                <button class="damson-btn w-full" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
