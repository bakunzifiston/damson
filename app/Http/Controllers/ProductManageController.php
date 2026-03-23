<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductManageController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('data-hub.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('data-hub.products.form', [
            'product' => new Product,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $validated['slug'] = $this->uniqueSlug($validated['name']);

        Product::query()->create($validated);

        return redirect()
            ->route('data-hub.products.index')
            ->with('status', 'Product created.');
    }

    public function edit(int $productId): View
    {
        $product = Product::query()->findOrFail($productId);

        return view('data-hub.products.form', [
            'product' => $product,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $product = Product::query()->findOrFail($productId);

        $validated = $this->validated($request, $product->id);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        if ($product->name !== $validated['name']) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $product->update($validated);

        return redirect()
            ->route('data-hub.products.index')
            ->with('status', 'Product updated.');
    }

    public function destroy(int $productId): RedirectResponse
    {
        $product = Product::query()->findOrFail($productId);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('data-hub.products.index')
            ->with('status', 'Product removed.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'cost_price' => $request->input('cost_price') === '' || $request->input('cost_price') === null
                ? null
                : $request->input('cost_price'),
        ]);

        $skuRule = ['required', 'string', 'max:64', 'unique:products,sku'];
        if ($ignoreId !== null) {
            $skuRule = ['required', 'string', 'max:64', 'unique:products,sku,'.$ignoreId];
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => $skuRule,
            'category' => ['required', 'string', 'max:64'],
            'unit' => ['required', 'string', 'max:32'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_active'] = (bool) (int) $request->input('is_active', 0);
        $validated['description'] = $validated['description'] ?? '';

        if (($validated['cost_price'] ?? null) === null || $validated['cost_price'] === '') {
            $validated['cost_price'] = null;
        }

        unset($validated['image']);

        return $validated;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'product';
        }

        $slug = $base;
        $n = 1;
        while (Product::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$n++;
        }

        return $slug;
    }
}
