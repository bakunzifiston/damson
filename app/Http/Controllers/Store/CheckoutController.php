<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $lines = $this->resolveLines($request);
        if ($lines === []) {
            return redirect()
                ->route('store.index')
                ->with('status', 'Your cart is empty.');
        }

        $subtotal = array_sum(array_column($lines, 'line_total'));

        return view('store.checkout', [
            'lines' => $lines,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $lines = $this->resolveLines($request);
        if ($lines === []) {
            return redirect()
                ->route('store.cart')
                ->withErrors(['cart' => 'Your cart is empty.']);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:64'],
            'shipping_address' => ['required', 'string', 'max:2000'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $subtotal = array_sum(array_column($lines, 'line_total'));

        try {
            $order = DB::transaction(function () use ($lines, $validated, $subtotal) {
                foreach ($lines as $line) {
                    /** @var Product $product */
                    $product = $line['product'];
                    $locked = Product::query()->whereKey($product->id)->lockForUpdate()->first();
                    if (! $locked || ! $locked->is_active) {
                        throw new \RuntimeException('Product no longer available: '.$product->name);
                    }
                    if ($line['quantity'] > $locked->stock) {
                        throw new \RuntimeException('Insufficient stock for '.$locked->name.' (only '.$locked->stock.' left).');
                    }
                }

                $orderNumber = $this->generateOrderNumber();

                $order = Order::query()->create([
                    'order_number' => $orderNumber,
                    'status' => Order::STATUS_PENDING,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'] ?? null,
                    'shipping_address' => $validated['shipping_address'],
                    'customer_notes' => $validated['customer_notes'] ?? null,
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                ]);

                foreach ($lines as $line) {
                    /** @var Product $product */
                    $product = $line['product'];
                    $qty = $line['quantity'];
                    $unitPrice = (float) $product->price;
                    $lineTotal = $unitPrice * $qty;

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku' => $product->sku ?? '',
                        'unit' => $product->unit,
                        'unit_price' => $unitPrice,
                        'quantity' => $qty,
                        'line_total' => $lineTotal,
                    ]);

                    Product::query()->whereKey($product->id)->decrement('stock', $qty);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['cart' => $e->getMessage()])->withInput();
        }

        $request->session()->forget(CartController::SESSION_KEY);
        $request->session()->put('placed_order_id', $order->id);

        return redirect()
            ->route('store.checkout.success', $order);
    }

    public function success(Request $request, Order $order): View
    {
        if ((int) $request->session()->get('placed_order_id') !== (int) $order->id) {
            abort(403);
        }

        $request->session()->forget('placed_order_id');

        $order->load('items');

        return view('store.checkout-success', compact('order'));
    }

    /** @return list<array{product: Product, quantity: int, line_total: float}> */
    private function resolveLines(Request $request): array
    {
        $cart = CartController::getCart($request);
        $lines = [];

        foreach ($cart as $productId => $qty) {
            if ($qty < 1) {
                continue;
            }
            $product = Product::query()->active()->whereKey($productId)->first();
            if (! $product) {
                continue;
            }
            if ($qty > $product->stock) {
                continue;
            }
            $lines[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => (float) $product->price * $qty,
            ];
        }

        return $lines;
    }

    private function generateOrderNumber(): string
    {
        do {
            $n = 'DM-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
        } while (Order::query()->where('order_number', $n)->exists());

        return $n;
    }
}
