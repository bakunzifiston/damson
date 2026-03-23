@extends('layouts.dashboard')

@section('title', $mode === 'create' ? 'Add product' : 'Edit product')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('data-hub.products.index') }}" class="text-sm font-medium text-damson-orange hover:text-damson-orange-hover">← Products</a>

        <div class="dashboard-card mt-6 p-6 sm:p-8">
            <h1 class="font-display text-xl font-semibold text-brand-950">{{ $mode === 'create' ? 'Add product' : 'Edit product' }}</h1>
            <p class="mt-2 text-sm text-stone-600">SKU must be unique. Slug for the public store URL is generated from the name.</p>

            <form action="{{ $mode === 'create' ? route('data-hub.products.store') : route('data-hub.products.update', $product->id) }}"
                  method="post"
                  enctype="multipart/form-data"
                  class="mt-6 space-y-4">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-stone-700" for="image">Image</label>
                    <input class="mt-1 block w-full text-sm text-stone-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-brand-950" type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp,image/gif">
                    @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @if ($mode === 'edit' && $product->image_path)
                        <p class="mt-2 text-xs text-stone-500">Current file is kept unless you choose a new image.</p>
                        <img src="{{ Storage::url($product->image_path) }}" alt="" class="mt-2 h-24 w-24 rounded-lg object-cover ring-1 ring-stone-200">
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700" for="name">Name</label>
                    <input class="damson-input" type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700" for="sku">SKU <span class="text-stone-400">(unique)</span></label>
                    <input class="damson-input" type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required autocomplete="off">
                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="category">Category</label>
                        <input class="damson-input" type="text" name="category" id="category" value="{{ old('category', $product->category) }}" placeholder="e.g. tubes, spawn, dmms" required>
                        @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="unit">Unit</label>
                        <input class="damson-input" type="text" name="unit" id="unit" value="{{ old('unit', $product->unit ?: 'piece') }}" placeholder="kg, piece, bag…" required list="unit-suggestions">
                        <datalist id="unit-suggestions">
                            <option value="piece">
                            <option value="kg">
                            <option value="g">
                            <option value="bag">
                            <option value="tray">
                            <option value="box">
                            <option value="unit">
                        </datalist>
                        @error('unit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="cost_price">Cost price</label>
                        <input class="damson-input" type="number" name="cost_price" id="cost_price" value="{{ old('cost_price', $product->cost_price) }}" min="0" step="0.01" placeholder="Optional">
                        @error('cost_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="price">Selling price</label>
                        <input class="damson-input" type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                        @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700" for="stock">Stock quantity</label>
                    <input class="damson-input" type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" step="1" required>
                    @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700" for="description">Description</label>
                    <textarea class="damson-input" name="description" id="description" rows="5" placeholder="Shown on the store product page (Markdown supported).">{{ old('description', $product->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-stone-300 text-brand-900 focus:ring-brand-500" @checked(old('is_active', $product->exists ? ($product->is_active ? '1' : '0') : '1') === '1')>
                    Visible on the public store
                </label>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button class="damson-btn rounded-xl" type="submit">{{ $mode === 'create' ? 'Create product' : 'Save changes' }}</button>
                    <a href="{{ route('data-hub.products.index') }}" class="damson-btn-outline rounded-xl">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
