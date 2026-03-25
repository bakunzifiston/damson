@extends('layouts.dashboard')

@section('title', 'Products')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">
                    <a href="{{ route('data-hub.index') }}" class="text-damson-orange hover:text-damson-orange-hover">Overview</a>
                    <span class="text-stone-300">/</span>
                    Catalog
                </p>
                <h1 class="mt-1 font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">Products</h1>
                <p class="mt-2 max-w-2xl text-sm text-stone-600">Manage store items: image, SKU, pricing, stock, and units.</p>
            </div>
            <a href="{{ route('data-hub.products.create') }}" class="damson-btn-accent shrink-0 rounded-xl px-6 shadow-md">Add product</a>
        </div>

        <div class="dashboard-card mt-8 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-sm">
                    <thead class="bg-brand-50/90">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Image</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Name</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">SKU</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Category</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Unit</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Cost</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Selling</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Stock</th>
                            <th scope="col" class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-600">Active</th>
                            <th scope="col" class="px-4 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($products as $product)
                            <tr class="hover:bg-brand-50/40">
                                <td class="px-4 py-2">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::disk("public")->url($product->image_path) }}" alt="" class="h-12 w-12 rounded-lg object-cover ring-1 ring-stone-200" width="48" height="48">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-stone-100 text-[10px] text-stone-400">—</div>
                                    @endif
                                </td>
                                <td class="max-w-[10rem] truncate px-4 py-2 font-medium text-stone-900">{{ $product->name }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-stone-700">{{ $product->sku }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-stone-600">{{ $product->category }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-stone-600">{{ $product->unit }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-right text-stone-700">{{ $product->cost_price !== null ? config('app.currency_symbol', '$').number_format((float) $product->cost_price, 2) : '—' }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-right font-medium text-stone-900">{{ config('app.currency_symbol', '$') }}{{ number_format((float) $product->price, 2) }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-right text-stone-700">{{ number_format($product->stock) }}</td>
                                <td class="px-4 py-2">
                                    @if ($product->is_active)
                                        <span class="inline-flex rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-900">Yes</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs text-stone-600">No</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-right">
                                    <a href="{{ route('data-hub.products.edit', $product->id) }}" class="text-sm font-semibold text-damson-orange hover:text-damson-orange-hover">Edit</a>
                                    <form action="{{ route('data-hub.products.destroy', $product->id) }}" method="post" class="ml-3 inline" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-16 text-center text-sm text-stone-500">
                                    No products yet. <a href="{{ route('data-hub.products.create') }}" class="font-semibold text-damson-orange hover:text-damson-orange-hover">Add your first product</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="border-t border-stone-100 bg-stone-50/80 px-4 py-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
