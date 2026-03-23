<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public const SESSION_KEY = 'store_cart';

    /** @return array<int, int> product_id => qty */
    public static function getCart(Request $request): array
    {
        $raw = $request->session()->get(self::SESSION_KEY, []);
        if (! is_array($raw)) {
            return [];
        }

        $cart = [];
        foreach ($raw as $id => $qty) {
            if (! is_numeric($id)) {
                continue;
            }
            $q = (int) $qty;
            if ($q > 0) {
                $cart[(int) $id] = $q;
            }
        }

        return $cart;
    }

    public static function cartCount(Request $request): int
    {
        return (int) array_sum(self::getCart($request));
    }

    public function index(Request $request): View
    {
        $cart = self::getCart($request);
        $lines = [];
        $subtotal = 0.0;

        foreach ($cart as $productId => $qty) {
            if ($qty < 1) {
                continue;
            }
            $product = Product::query()->active()->whereKey($productId)->first();
            if (! $product) {
                continue;
            }
            $line = (float) $product->price * $qty;
            $subtotal += $line;
            $lines[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $line,
            ];
        }

        return view('store.cart', [
            'lines' => $lines,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::query()->active()->findOrFail($data['product_id']);
        $qty = $data['quantity'];

        $cart = self::getCart($request);
        $current = (int) ($cart[$product->id] ?? 0);
        $newQty = $current + $qty;

        if ($newQty > $product->stock) {
            return back()->withErrors([
                'quantity' => 'Only '.$product->stock.' available in stock for '.$product->name.'.',
            ])->withInput();
        }

        $cart[$product->id] = $newQty;
        $request->session()->put(self::SESSION_KEY, $cart);

        return back()->with('status', 'Added to cart.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $product = Product::query()->active()->findOrFail($productId);
        $cart = self::getCart($request);

        if ($data['quantity'] === 0) {
            unset($cart[$productId]);
        } else {
            if ($data['quantity'] > $product->stock) {
                return back()->withErrors([
                    'quantity' => 'Maximum stock for this item is '.$product->stock.'.',
                ]);
            }
            $cart[$productId] = $data['quantity'];
        }

        $request->session()->put(self::SESSION_KEY, $cart);

        return back()->with('status', 'Cart updated.');
    }

    public function remove(Request $request, int $productId): RedirectResponse
    {
        $cart = self::getCart($request);
        unset($cart[$productId]);
        $request->session()->put(self::SESSION_KEY, $cart);

        return back()->with('status', 'Item removed.');
    }
}
