@extends('layouts.dashboard')

@php
    $editing = $item->exists;
    $currentType = old('type', $item->type ?: 'article');
@endphp

@section('title', $editing ? 'Edit resource' : 'Add resource')

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-dash-header :title="$editing ? 'Edit resource' : 'Add resource'" :crumbs="[['label' => 'Resources', 'url' => route('data-hub.resources.index')], ['label' => $editing ? 'Edit' : 'New']]" />

        <form action="{{ $editing ? route('data-hub.resources.update', $item) : route('data-hub.resources.store') }}" method="post" enctype="multipart/form-data"
              class="dashboard-card mt-6 space-y-5 p-6 sm:p-8" data-resource-form>
            @csrf
            @if ($editing) @method('PUT') @endif

            <x-field name="type" label="Type" type="select" required help="Choose what kind of resource this is. The form shows the fields it needs.">
                @foreach ($types as $key => $label)
                    <option value="{{ $key }}" @selected($currentType === $key)>{{ \Illuminate\Support\Str::singular($label) }}</option>
                @endforeach
            </x-field>

            <x-field name="title" label="Title" :value="$item->title" required />
            <x-field name="excerpt" label="Summary" type="textarea" :rows="2" :value="$item->excerpt" optional help="Short description shown on cards (max 500 characters)." />

            {{-- Articles and guides --}}
            <div data-for="article guide" class="space-y-5">
                <x-field name="slug" label="URL slug" :value="$item->slug" optional
                         :help="$editing ? 'Part of the public URL. Leave unchanged to keep existing links working.' : 'Leave blank to generate from the title.'" placeholder="my-title" />
                <x-field name="body" label="Body" type="textarea" :rows="14" :value="$item->body" help="Markdown is supported. Raw HTML is removed for safety." class="font-mono" />
            </div>

            {{-- Guides --}}
            <div data-for="guide" class="grid gap-5 sm:grid-cols-2">
                <x-field name="difficulty" label="Difficulty" type="select">
                    @foreach ($difficulties as $d)<option value="{{ $d }}" @selected(old('difficulty', $item->difficulty ?: 'beginner') === $d)>{{ ucfirst($d) }}</option>@endforeach
                </x-field>
                <x-field name="sort_order" label="Display order" type="number" min="0" :value="$item->sort_order ?? 0" help="Lower numbers appear first." />
            </div>

            {{-- Downloads --}}
            <div data-for="download" class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="damson-label" for="category">Category</label>
                        <input class="damson-input" id="category" name="category" type="text" list="category-options" maxlength="64" value="{{ old('category', $item->category) }}" @error('category') aria-invalid="true" @enderror>
                        <datalist id="category-options">@foreach ($categories as $c)<option value="{{ $c }}">@endforeach</datalist>
                        <p class="damson-help">Downloads are grouped by category.</p>
                        @error('category')<p class="damson-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="damson-label" for="format">Format</label>
                        <input class="damson-input" id="format" name="format" type="text" list="format-options" maxlength="32" value="{{ old('format', $item->format ?: 'pdf') }}" @error('format') aria-invalid="true" @enderror>
                        <datalist id="format-options">@foreach ($formats as $f)<option value="{{ $f }}">@endforeach</datalist>
                        @error('format')<p class="damson-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <x-field name="external_url" label="External link" type="url" :value="$item->external_url" optional placeholder="https://…" help="Shown as “Open”. If you also upload a file, the link takes priority." />
                <div>
                    <label class="damson-label" for="file">File <span class="font-normal text-stone-400">(optional)</span></label>
                    <input class="mt-2 block w-full text-sm text-stone-600 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-brand-950" type="file" name="file" id="file">
                    <p class="damson-help">PDF, Office documents, CSV, TXT, ZIP or images. Max 10 MB.</p>
                    @error('file')<p class="damson-error">{{ $message }}</p>@enderror
                    @if ($editing && $item->file_path)
                        <p class="mt-2 text-sm text-stone-600">Current file: <a class="font-medium text-brand-700 underline" href="{{ $item->file_url }}" target="_blank" rel="noopener">{{ basename($item->file_path) }}</a></p>
                        <label class="mt-2 flex items-center gap-2 text-sm text-stone-700"><input type="checkbox" name="remove_file" value="1" class="h-4 w-4 rounded border-stone-300"> Remove current file</label>
                    @endif
                </div>
            </div>

            {{-- Publishing --}}
            <div class="grid items-end gap-5 border-t border-stone-100 pt-5 sm:grid-cols-2">
                <div data-for="article">
                    <x-field name="published_at" label="Publish date" type="datetime-local" :value="$item->published_at?->format('Y-m-d\TH:i')" optional help="A future date schedules it." />
                </div>
                <label class="flex items-center gap-2.5 pb-2 text-sm text-stone-700">
                    <input type="checkbox" name="is_published" value="1" class="h-4 w-4 rounded border-stone-300" @checked(old('is_published', $editing ? $item->is_published : true))>
                    Published (uncheck to keep as a draft)
                </label>
            </div>

            <div class="flex flex-wrap gap-3 pt-1">
                <button type="submit" class="damson-btn">{{ $editing ? 'Save changes' : 'Create' }}</button>
                <a href="{{ route('data-hub.resources.index') }}" class="damson-btn-outline">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Show only the fields relevant to the selected type (all stay visible without JavaScript). --}}
    <script>
        (function () {
            var form = document.querySelector('[data-resource-form]');
            if (!form) return;
            var select = form.querySelector('#type');
            function sync() {
                form.querySelectorAll('[data-for]').forEach(function (el) {
                    var show = el.getAttribute('data-for').split(' ').indexOf(select.value) !== -1;
                    el.hidden = !show;
                    el.querySelectorAll('input, select, textarea').forEach(function (f) { f.disabled = !show; });
                });
            }
            select.addEventListener('change', sync);
            sync();
        })();
    </script>
@endsection
