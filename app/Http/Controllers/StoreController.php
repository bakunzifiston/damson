<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $active = Product::query()->active();

        $stats = (clone $active)->selectRaw('MIN(price) as min_p, MAX(price) as max_p, COUNT(*) as total')->first();
        $totalCatalog = (int) ($stats->total ?? 0);

        if ($totalCatalog === 0) {
            $floor = 0.0;
            $ceil = 1000.0;
        } else {
            $floor = (float) $stats->min_p;
            $ceil = (float) $stats->max_p;
            if ($floor >= $ceil) {
                $ceil = $floor + 0.01;
            }
        }

        $categoryCounts = (clone $active)
            ->selectRaw('category, COUNT(*) as c')
            ->groupBy('category')
            ->orderBy('category')
            ->pluck('c', 'category');

        $minP = $request->filled('min_price')
            ? (float) $request->input('min_price')
            : $floor;
        $maxP = $request->filled('max_price')
            ? (float) $request->input('max_price')
            : $ceil;

        $minP = max($floor, min($minP, $ceil));
        $maxP = max($floor, min($maxP, $ceil));
        if ($minP > $maxP) {
            [$minP, $maxP] = [$maxP, $minP];
        }

        $category = $request->string('category')->trim()->toString();

        $q = Product::query()->active();

        if ($category !== '') {
            $q->where('category', $category);
        }

        if ($totalCatalog > 0) {
            $q->whereBetween('price', [$minP, $maxP]);
        }

        $sort = $request->input('sort', 'default');
        match ($sort) {
            'price_asc' => $q->orderBy('price')->orderBy('name'),
            'price_desc' => $q->orderByDesc('price')->orderBy('name'),
            'name' => $q->orderBy('name'),
            default => $q->orderBy('category')->orderBy('name'),
        };

        $products = $q->paginate(12)->withQueryString();

        return view('store.index', [
            'products' => $products,
            'categoryCounts' => $categoryCounts,
            'floor' => $floor,
            'ceil' => $ceil,
            'minP' => $minP,
            'maxP' => $maxP,
            'category' => $category,
            'sort' => $sort,
            'totalCatalog' => $totalCatalog,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('store.show', compact('product'));
    }
}
