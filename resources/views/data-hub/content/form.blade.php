@extends('layouts.dashboard')

@php $editing = $item->exists; @endphp

@section('title', $editing ? 'Edit FAQ' : 'Add FAQ')

@section('content')
    <div class="mx-auto max-w-2xl">
        <x-dash-header :title="$editing ? 'Edit FAQ' : 'Add FAQ'" :crumbs="[['label' => 'FAQs', 'url' => route('data-hub.content.index')], ['label' => $editing ? 'Edit' : 'New']]" />

        <form action="{{ $editing ? route('data-hub.content.update', $item) : route('data-hub.content.store') }}" method="post" class="dashboard-card mt-6 space-y-5 p-6 sm:p-8">
            @csrf
            @if ($editing) @method('PUT') @endif
            <x-field name="question" label="Question" :value="$item->question" required />
            <x-field name="answer" label="Answer" type="textarea" :rows="5" :value="$item->answer" required />
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="damson-label" for="category">Category <span class="font-normal text-stone-400">(optional)</span></label>
                    <input class="damson-input" id="category" name="category" type="text" list="category-options" maxlength="64" value="{{ old('category', $item->category) }}">
                    <datalist id="category-options">@foreach ($categories as $c)<option value="{{ $c }}">@endforeach</datalist>
                    @error('category')<p class="damson-error">{{ $message }}</p>@enderror
                </div>
                <x-field name="sort_order" label="Display order" type="number" min="0" :value="$item->sort_order ?? 0" help="Lower numbers appear first." />
            </div>
            <div class="flex flex-wrap gap-3 pt-1">
                <button type="submit" class="damson-btn">{{ $editing ? 'Save changes' : 'Create' }}</button>
                <a href="{{ route('data-hub.content.index') }}" class="damson-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
