@extends('layouts.site')

@section('title', 'Apply for Mushroom Farming Training')

@section('content')
    <x-simple-hero title="Apply for Mushroom Farming Training" subtitle="Tell us about yourself and what you want to learn. Our team will contact you on WhatsApp or email." />

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-12">
        @if (session('applied'))
            <div class="dashboard-card p-8 text-center sm:p-12" role="status">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-700" aria-hidden="true">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <h2 class="mt-5 font-display text-2xl font-semibold text-brand-950">Application received</h2>
                <p class="mx-auto mt-2 max-w-md text-stone-600">Thank you for applying. Our team will review your application and contact you soon.</p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('learning.index') }}" class="damson-btn">Back to Learning</a>
                    <a href="{{ route('learning.resources') }}" class="damson-btn-outline">Browse resources</a>
                </div>
            </div>
        @else
            <form action="{{ route('learning.apply.store') }}" method="post" class="space-y-8" data-submit-once>
                @csrf
                {{-- Honeypot: hidden from people, often filled by bots --}}
                <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

                <section class="dashboard-card space-y-5 p-6 sm:p-8" aria-labelledby="about-you">
                    <h2 id="about-you" class="text-sm font-semibold text-stone-900">About you</h2>
                    <x-field name="full_name" label="Full name" required autocomplete="name" />
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-field name="phone" label="Phone number (WhatsApp)" type="tel" required autocomplete="tel" inputmode="tel" placeholder="+250 7XX XXX XXX" />
                        <x-field name="email" label="Email address" type="email" required autocomplete="email" />
                    </div>
                    <x-field name="district" label="District / Sector of residence" required autocomplete="address-level2" placeholder="e.g. Rubavu / Rugerero" />
                </section>

                <section class="dashboard-card space-y-6 p-6 sm:p-8" aria-labelledby="your-training">
                    <h2 id="your-training" class="text-sm font-semibold text-stone-900">Your training</h2>

                    <fieldset @error('training_mode') aria-invalid="true" @enderror>
                        <legend class="damson-label">Which training mode do you prefer? <span class="text-red-600" aria-hidden="true">*</span></legend>
                        <div class="mt-2 space-y-2">
                            @foreach ($modes as $value => $label)
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-stone-200 p-3 text-sm text-stone-700 transition has-[:checked]:border-brand-900 has-[:checked]:bg-brand-50 hover:border-stone-300">
                                    <input type="radio" name="training_mode" value="{{ $value }}" class="mt-0.5 h-4 w-4" @checked(old('training_mode') === $value) required>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('training_mode')<p class="damson-error">{{ $message }}</p>@enderror
                    </fieldset>

                    <fieldset>
                        <legend class="damson-label">Which area of mushroom farming are you interested in? <span class="text-red-600" aria-hidden="true">*</span></legend>
                        <p class="damson-help !mt-0.5">Select all that apply.</p>
                        <div class="mt-2 grid gap-2 sm:grid-cols-2">
                            @foreach ($interests as $i => $label)
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-stone-200 p-3 text-sm text-stone-700 transition has-[:checked]:border-brand-900 has-[:checked]:bg-brand-50 hover:border-stone-300">
                                    <input type="checkbox" name="interests[]" value="{{ $label }}" class="mt-0.5 h-4 w-4 rounded border-stone-300" @checked(in_array($label, (array) old('interests', [])))>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('interests')<p class="damson-error">{{ $message }}</p>@enderror
                        @error('interests.*')<p class="damson-error">{{ $message }}</p>@enderror
                    </fieldset>

                    <fieldset>
                        <legend class="damson-label">Do you have previous experience in mushroom farming and production? <span class="text-red-600" aria-hidden="true">*</span></legend>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($experience as $value => $label)
                                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-stone-200 px-4 py-2.5 text-sm text-stone-700 transition has-[:checked]:border-brand-900 has-[:checked]:bg-brand-50 hover:border-stone-300">
                                    <input type="radio" name="experience" value="{{ $value }}" class="h-4 w-4" @checked(old('experience') === $value) required>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        @error('experience')<p class="damson-error">{{ $message }}</p>@enderror
                    </fieldset>

                    <fieldset>
                        <legend class="damson-label">When would you prefer to attend the training? <span class="text-red-600" aria-hidden="true">*</span></legend>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($timing as $value => $label)
                                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-stone-200 px-4 py-2.5 text-sm text-stone-700 transition has-[:checked]:border-brand-900 has-[:checked]:bg-brand-50 hover:border-stone-300">
                                    <input type="radio" name="start_preference" value="{{ $value }}" class="h-4 w-4" @checked(old('start_preference') === $value) required>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        @error('start_preference')<p class="damson-error">{{ $message }}</p>@enderror
                    </fieldset>

                    <x-field name="objective" label="What is your main objective for attending this training?" type="textarea" :rows="5" required maxlength="2000" />
                </section>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <button type="submit" class="damson-btn-accent px-8 py-3" data-loading-text="Submitting…">Submit application</button>
                    <p class="text-xs text-stone-500">We only use your details to contact you about training.</p>
                </div>
            </form>
        @endif
    </div>
@endsection
