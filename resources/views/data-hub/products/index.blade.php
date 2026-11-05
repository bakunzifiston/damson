@extends('layouts.dashboard')

@section('title', 'Products')

@php
    $sym = config('app.currency_symbol', '$');
@endphp

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="Products" subtitle="Manage store items: image, SKU, pricing, stock, and units." :crumbs="[['label' => 'Products']]">
            <x-slot:actions>
                <a href="{{ route('data-hub.products.create') }}" class="damson-btn-accent">Add product</a>
            </x-slot:actions>
        </x-dash-header>

        <div class="dashboard-card mt-6 overflow-hidden">
            <x-list-toolbar placeholder="Search name, SKU or category…">
                <div>
                    <label for="category" class="sr-only">Category</label>
                    <select id="category" name="category" class="damson-input !mt-0">
                        <option value="">All categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="visibility" class="sr-only">Visibility</label>
                    <select id="visibility" name="visibility" class="damson-input !mt-0">
                        <option value="">Any visibility</option>
                        <option value="visible" @selected(request('visibility') === 'visible')>Visible</option>
                        <option value="hidden" @selected(request('visibility') === 'hidden')>Hidden</option>
                    </select>
                </div>
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="low_stock" value="1" class="h-4 w-4 rounded border-stone-300" @checked(request()->boolean('low_stock'))>
                    Low stock (≤ {{ $lowStockThreshold }})
                </label>
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="name" label="Product" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="sku" label="SKU" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="category" label="Category" :sort="$sort" :dir="$dir" />
                            <th scope="col" class="is-right">Cost</th>
                            <x-sort-th column="price" label="Price" :sort="$sort" :dir="$dir" right />
                            <x-sort-th column="stock" label="Stock" :sort="$sort" :dir="$dir" right />
                            <th scope="col">Status</th>
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if ($product->image_path)
                                            <img src="{{ $product->image_url }}" alt="" class="h-11 w-11 shrink-0 rounded-lg object-cover ring-1 ring-stone-200" width="44" height="44" loading="lazy">
                                        @else
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-xs text-stone-400" aria-hidden="true">—</div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="max-w-[14rem] truncate font-medium text-stone-900">{{ $product->name }}</p>
                                            <p class="text-xs text-stone-500">per {{ $product->unit }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap font-mono text-xs">{{ $product->sku }}</td>
                                <td class="whitespace-nowrap">{{ $product->category }}</td>
                                <td class="is-right whitespace-nowrap tabular-nums">{{ $product->cost_price !== null ? $sym.number_format((float) $product->cost_price, 2) : '—' }}</td>
                                <td class="is-right whitespace-nowrap font-medium tabular-nums text-stone-900">{{ $sym }}{{ number_format((float) $product->price, 2) }}</td>
                                <td class="is-right tabular-nums {{ $product->stock <= $lowStockThreshold ? 'font-semibold text-amber-700' : '' }}">{{ number_format($product->stock) }}@if ($product->stock <= $lowStockThreshold)<span class="sr-only"> (low stock)</span>@endif</td>
                                <td>
                                    @if ($product->is_active)
                                        <span class="badge badge-success">Visible</span>
                                    @else
                                        <span class="badge badge-neutral">Hidden</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.products.edit', $product->id) }}" class="damson-btn-outline damson-btn-sm">Edit<span class="sr-only"> {{ $product->name }}</span></a>
                                    <form action="{{ route('data-hub.products.destroy', $product->id) }}" method="post" class="ml-1 inline" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="damson-btn-danger damson-btn-sm">Delete<span class="sr-only"> {{ $product->name }}</span></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    @if (request()->hasAny(['q', 'category', 'visibility', 'low_stock']))
                                        <x-empty-state title="No matching products" text="Try a different search or reset the filters." />
                                    @else
                                        <x-empty-state title="No products yet" text="Add your first product to show it in the store.">
                                            <a href="{{ route('data-hub.products.create') }}" class="damson-btn-accent">Add product</a>
                                        </x-empty-state>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
@endsection
