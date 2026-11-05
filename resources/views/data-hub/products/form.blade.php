@extends('layouts.dashboard')

@section('title', $mode === 'create' ? 'Add product' : 'Edit product')

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-dash-header :title="$mode === 'create' ? 'Add product' : 'Edit product'"
                       subtitle="SKU must be unique. The public store URL is generated from the name."
                       :crumbs="[['label' => 'Products', 'url' => route('data-hub.products.index')], ['label' => $mode === 'create' ? 'New' : 'Edit']]" />

        <form action="{{ $mode === 'create' ? route('data-hub.products.store') : route('data-hub.products.update', $product->id) }}"
              method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif

            <section class="dashboard-card space-y-5 p-6" aria-labelledby="basics">
                <h2 id="basics" class="text-sm font-semibold text-stone-900">Basics</h2>
                <x-field name="name" label="Name" :value="$product->name" required />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="sku" label="SKU" :value="$product->sku" help="Must be unique." required autocomplete="off" />
                    <x-field name="category" label="Category" :value="$product->category" placeholder="e.g. tubes, spawn, dmms" required />
                </div>
                <x-field name="description" label="Description" type="textarea" :rows="5" :value="$product->description" optional
                         placeholder="Shown on the store product page (Markdown supported)." />
            </section>

            <section class="dashboard-card space-y-5 p-6" aria-labelledby="pricing">
                <h2 id="pricing" class="text-sm font-semibold text-stone-900">Pricing &amp; stock</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="price" label="Selling price" type="number" :value="$product->price" min="0" step="0.01" required />
                    <x-field name="cost_price" label="Cost price" type="number" :value="$product->cost_price" min="0" step="0.01" optional />
                    <x-field name="stock" label="Stock quantity" type="number" :value="$product->stock ?? 0" min="0" step="1" required />
                    <div>
                        <label class="damson-label" for="unit">Unit</label>
                        <input class="damson-input" type="text" name="unit" id="unit" value="{{ old('unit', $product->unit ?: 'piece') }}" placeholder="kg, piece, bag…" required list="unit-suggestions" @error('unit') aria-invalid="true" @enderror>
                        <datalist id="unit-suggestions">
                            @foreach (['piece', 'kg', 'g', 'bag', 'tray', 'box', 'unit'] as $u)
                                <option value="{{ $u }}">
                            @endforeach
                        </datalist>
                        @error('unit')<p class="damson-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="dashboard-card space-y-5 p-6" aria-labelledby="media">
                <h2 id="media" class="text-sm font-semibold text-stone-900">Image &amp; visibility</h2>
                <div>
                    <label class="damson-label" for="image">Image</label>
                    <div class="mt-2 flex flex-wrap items-center gap-4">
                        @if ($mode === 'edit' && $product->image_path)
                            <img src="{{ $product->image_url }}" alt="Current product image" class="h-20 w-20 rounded-lg object-cover ring-1 ring-stone-200">
                        @endif
                        <input class="block min-w-0 flex-1 text-sm text-stone-600 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-brand-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-brand-950" type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp,image/gif">
                    </div>
                    @if ($mode === 'edit' && $product->image_path)<p class="damson-help">The current image is kept unless you choose a new one.</p>@endif
                    @error('image')<p class="damson-error">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-2.5 text-sm text-stone-700">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-stone-300" @checked(old('is_active', $product->exists ? ($product->is_active ? '1' : '0') : '1') === '1')>
                    Visible on the public store
                </label>
            </section>

            <div class="flex flex-wrap gap-3">
                <button class="damson-btn" type="submit">{{ $mode === 'create' ? 'Create product' : 'Save changes' }}</button>
                <a href="{{ route('data-hub.products.index') }}" class="damson-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
