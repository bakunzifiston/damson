@extends('layouts.dashboard')

@section('title', 'Application — '.$application->full_name)

@section('content')
    @php $a = $application; @endphp
    <div class="mx-auto max-w-5xl">
        <x-dash-header :title="$a->full_name" :subtitle="'Submitted '.$a->created_at->format('F j, Y \a\t g:i a')"
                       :crumbs="[['label' => 'Training applications', 'url' => route('data-hub.training.index')], ['label' => $a->full_name]]">
            <x-slot:actions>
                <x-status-badge :status="$a->status" :label="$a->status_label" />
            </x-slot:actions>
        </x-dash-header>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <section class="dashboard-card p-6" aria-labelledby="contact-title">
                    <h2 id="contact-title" class="text-sm font-semibold text-stone-900">Contact</h2>
                    <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                        <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Phone / WhatsApp</dt>
                            <dd class="mt-1">
                                <a href="tel:{{ $a->whatsapp_number }}" class="font-medium text-brand-700 hover:underline">{{ $a->phone }}</a>
                                @if ($a->whatsapp_number)<a href="https://wa.me/{{ $a->whatsapp_number }}" target="_blank" rel="noopener noreferrer" class="ml-2 text-xs font-medium text-emerald-700 hover:underline">Message on WhatsApp<span class="sr-only"> (opens in a new tab)</span></a>@endif
                            </dd></div>
                        <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Email</dt>
                            <dd class="mt-1"><a href="mailto:{{ $a->email }}" class="font-medium text-brand-700 hover:underline">{{ $a->email }}</a></dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">District / Sector</dt>
                            <dd class="mt-1 text-stone-800">{{ $a->district }}</dd></div>
                    </dl>
                </section>

                <section class="dashboard-card p-6" aria-labelledby="training-title">
                    <h2 id="training-title" class="text-sm font-semibold text-stone-900">Training request</h2>
                    <dl class="mt-4 space-y-4 text-sm">
                        <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Preferred mode</dt><dd class="mt-1 text-stone-800">{{ $a->mode_label }}</dd></div>
                        <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Areas of interest</dt>
                            <dd class="mt-1.5 flex flex-wrap gap-2">@foreach ($a->interests as $interest)<span class="badge badge-neutral">{{ $interest }}</span>@endforeach</dd></div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Previous experience</dt><dd class="mt-1 text-stone-800">{{ $a->experience_label }}</dd></div>
                            <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Preferred start</dt><dd class="mt-1 text-stone-800">{{ $a->start_preference_label }}</dd></div>
                        </div>
                        <div><dt class="text-xs font-medium uppercase tracking-wide text-stone-500">Main objective</dt><dd class="mt-1 whitespace-pre-line text-stone-800">{{ $a->objective }}</dd></div>
                    </dl>
                </section>
            </div>

            <form action="{{ route('data-hub.training.update', $a) }}" method="post" class="dashboard-card h-fit space-y-5 p-6 lg:sticky lg:top-6">
                @csrf
                @method('PUT')
                <h2 class="text-sm font-semibold text-stone-900">Manage application</h2>
                <x-field name="status" label="Status" type="select" required>
                    @foreach (\App\Models\TrainingApplication::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $a->status) === $key)>{{ $label }}</option>
                    @endforeach
                </x-field>
                <x-field name="admin_notes" label="Internal notes" type="textarea" :rows="6" :value="$a->admin_notes" optional help="Only staff can see these notes." />
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="damson-btn">Save</button>
                    <a href="{{ route('data-hub.training.index') }}" class="damson-btn-outline">Back to list</a>
                </div>
                <p class="text-xs text-stone-500">Last updated {{ $a->updated_at->diffForHumans() }}</p>
            </form>
        </div>
    </div>
@endsection
