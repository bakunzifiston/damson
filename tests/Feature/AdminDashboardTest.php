<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\DmmsMonitoringRecord;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SalesRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function product(array $attrs = []): Product
    {
        return Product::query()->create($attrs + [
            'name' => 'Oyster Tube', 'slug' => 'oyster-tube-'.uniqid(), 'sku' => 'SKU-'.uniqid(),
            'category' => 'tubes', 'unit' => 'piece', 'description' => '', 'price' => 10, 'stock' => 20, 'is_active' => true,
        ]);
    }

    private function order(Product $product, int $qty = 3, string $status = 'pending'): Order
    {
        $order = Order::query()->create([
            'order_number' => 'DM-T-'.uniqid(), 'status' => $status, 'payment_method' => 'cash_on_delivery',
            'customer_name' => 'Jane', 'customer_email' => 'jane@example.com', 'shipping_address' => 'Kigali',
            'subtotal' => $product->price * $qty, 'total' => $product->price * $qty,
        ]);
        OrderItem::query()->create([
            'order_id' => $order->id, 'product_id' => $product->id, 'product_name' => $product->name, 'sku' => $product->sku,
            'unit' => 'piece', 'unit_price' => $product->price, 'quantity' => $qty, 'line_total' => $product->price * $qty,
        ]);

        return $order;
    }

    // ---------- Authentication & route protection ----------

    public function test_guests_are_redirected_from_every_admin_route(): void
    {
        $product = $this->product();
        $order = $this->order($product);

        foreach ([
            ['get', '/data-hub'],
            ['get', '/data-hub/module/sales'],
            ['get', '/data-hub/module/sales/export'],
            ['get', '/data-hub/contacts/create'],
            ['post', '/data-hub/contacts'],
            ['get', '/data-hub/orders'],
            ['get', "/data-hub/orders/{$order->id}"],
            ['patch', "/data-hub/orders/{$order->id}/status"],
            ['get', '/data-hub/products'],
            ['get', '/data-hub/products/create'],
            ['post', '/data-hub/products'],
            ['get', "/data-hub/products/{$product->id}/edit"],
            ['put', "/data-hub/products/{$product->id}"],
            ['delete', "/data-hub/products/{$product->id}"],
        ] as [$method, $uri]) {
            $this->{$method}($uri)->assertRedirect('/login');
        }

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_login_logout_and_invalid_credentials(): void
    {
        $user = User::factory()->create(['email' => 'a@damson.test', 'password' => 'secret-pass']);

        $this->post('/login', ['email' => 'a@damson.test', 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/login', ['email' => 'a@damson.test', 'password' => 'secret-pass'])->assertRedirect('/data-hub');
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->get('/data-hub')->assertRedirect('/login');
    }

    public function test_login_is_rate_limited(): void
    {
        User::factory()->create(['email' => 'a@damson.test', 'password' => 'secret-pass']);
        RateLimiter::clear('a@damson.test|127.0.0.1');

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'a@damson.test', 'password' => 'bad']);
        }

        $this->post('/login', ['email' => 'a@damson.test', 'password' => 'secret-pass'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // ---------- Overview metrics ----------

    public function test_overview_metrics_are_computed_from_the_database(): void
    {
        $this->actingAs(User::factory()->create());
        $p = $this->product(['price' => 10, 'stock' => 2]);          // low stock
        $this->product(['stock' => 50]);                              // healthy
        $this->product(['stock' => 0, 'is_active' => false]);         // inactive: not counted as low stock
        $this->order($p, 3, 'pending');                                // 30, open
        $this->order($p, 2, 'completed');                              // 20
        $this->order($p, 9, 'cancelled');                              // excluded from revenue
        DmmsMonitoringRecord::query()->create(['farm_name' => 'F1', 'recorded_at' => now(), 'alert_message' => 'Too hot']);

        $response = $this->get('/data-hub')->assertOk();

        $response->assertViewHas('revenue', 50.0);
        $response->assertViewHas('openOrders', 1);
        $response->assertViewHas('orderCount', 3);
        $response->assertViewHas('productCount', 3);
        $response->assertViewHas('lowStockCount', 1);
        $response->assertSee('Too hot');
        $this->assertSame(2, array_sum(array_column($response->viewData('series'), 'orders')));
        $this->assertCount(14, $response->viewData('series'));
    }

    public function test_overview_renders_with_empty_database(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/data-hub')->assertOk()->assertViewHas('revenue', 0.0);
    }

    // ---------- Module lists: search, filter, sort, export ----------

    public function test_module_search_filter_sort_and_pagination(): void
    {
        $this->actingAs(User::factory()->create());
        SalesRecord::query()->create(['customer_name' => 'Alpha Co', 'product_line' => 'Tubes', 'amount' => 5, 'payment_status' => 'paid']);
        SalesRecord::query()->create(['customer_name' => 'Beta Ltd', 'product_line' => 'Spawn', 'amount' => 9, 'payment_status' => 'pending']);
        SalesRecord::query()->create(['customer_name' => '100% Real', 'product_line' => 'Spawn', 'amount' => 1, 'payment_status' => 'paid']);

        $this->get('/data-hub/module/sales?q=alpha')->assertSee('Alpha Co')->assertDontSee('Beta Ltd');
        $this->get('/data-hub/module/sales?payment_status=pending')->assertSee('Beta Ltd')->assertDontSee('Alpha Co');
        // LIKE wildcards are matched literally
        $this->get('/data-hub/module/sales?q=%25')->assertSee('100% Real')->assertDontSee('Alpha Co');
        // invalid sort column falls back to the default instead of erroring
        $this->get('/data-hub/module/sales?sort=password;drop&dir=sideways')->assertOk();
        $this->get('/data-hub/module/sales?sort=amount&dir=asc')->assertOk()->assertSeeInOrder(['100% Real', 'Alpha Co', 'Beta Ltd']);
        $this->get('/data-hub/module/unknown')->assertNotFound();

        foreach (range(1, 25) as $i) {
            SalesRecord::query()->create(['customer_name' => "Bulk $i", 'product_line' => 'X']);
        }
        $this->get('/data-hub/module/sales?page=2')->assertOk();
    }

    public function test_csv_export_respects_filters_and_neutralises_formulas(): void
    {
        $this->actingAs(User::factory()->create());
        SalesRecord::query()->create(['customer_name' => '=HYPERLINK("http://x")', 'product_line' => 'Tubes', 'payment_status' => 'paid']);
        SalesRecord::query()->create(['customer_name' => 'Normal', 'product_line' => 'Spawn', 'payment_status' => 'pending']);

        $response = $this->get('/data-hub/module/sales/export?payment_status=paid');
        $response->assertOk()->assertDownload();
        $csv = $response->streamedContent();

        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringNotContainsString('Normal', $csv);
        $this->assertStringContainsString('customer_name', $csv);
    }

    public function test_staff_can_add_a_contact_message_with_validation(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/data-hub/contacts', ['name' => ''])->assertSessionHasErrors(['name', 'email', 'message']);
        $this->post('/data-hub/contacts', ['name' => 'Sam', 'email' => 'sam@example.com', 'message' => 'Hello'])
            ->assertRedirect('/data-hub/module/contacts');
        $this->assertDatabaseHas('contact_messages', ['email' => 'sam@example.com']);
        $this->assertSame(1, ContactMessage::query()->count());
    }

    // ---------- Products CRUD ----------

    public function test_product_crud_with_image_upload_and_cleanup(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $this->post('/data-hub/products', [])->assertSessionHasErrors(['name', 'sku', 'category', 'unit', 'price', 'stock']);

        $this->post('/data-hub/products', [
            'name' => 'Shiitake Spawn', 'sku' => 'SH-1', 'category' => 'spawn', 'unit' => 'kg', 'price' => '12.50',
            'stock' => 7, 'is_active' => 1, 'image' => UploadedFile::fake()->image('a.jpg'),
        ])->assertRedirect('/data-hub/products');

        $product = Product::query()->where('sku', 'SH-1')->firstOrFail();
        $this->assertSame('shiitake-spawn', $product->slug);
        Storage::disk('public')->assertExists($product->image_path);
        $oldImage = $product->image_path;

        // duplicate SKU rejected; non-image rejected
        $this->post('/data-hub/products', ['name' => 'Other', 'sku' => 'SH-1', 'category' => 'x', 'unit' => 'kg', 'price' => 1, 'stock' => 1])
            ->assertSessionHasErrors('sku');
        $this->put("/data-hub/products/{$product->id}", [
            'name' => 'Shiitake Spawn', 'sku' => 'SH-1', 'category' => 'spawn', 'unit' => 'kg', 'price' => 1, 'stock' => 1,
            'image' => UploadedFile::fake()->create('x.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors('image');

        // update keeps own SKU, replaces image, deletes the old file, hides the product
        $this->put("/data-hub/products/{$product->id}", [
            'name' => 'Shiitake Spawn XL', 'sku' => 'SH-1', 'category' => 'spawn', 'unit' => 'kg', 'price' => 15, 'stock' => 3,
            'is_active' => 0, 'image' => UploadedFile::fake()->image('b.jpg'),
        ])->assertRedirect('/data-hub/products');

        $product->refresh();
        $this->assertSame('shiitake-spawn-xl', $product->slug);
        $this->assertFalse($product->is_active);
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($product->image_path);

        $this->get('/data-hub/products?q=SH-1&visibility=hidden')->assertOk()->assertSee('Shiitake Spawn XL');
        $this->get('/data-hub/products?visibility=visible')->assertOk()->assertDontSee('Shiitake Spawn XL');
        $this->get("/data-hub/products/{$product->id}/edit")->assertOk();

        $image = $product->image_path;
        $this->delete("/data-hub/products/{$product->id}")->assertRedirect('/data-hub/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing($image);
    }

    public function test_deleting_a_product_keeps_historical_order_items(): void
    {
        $this->actingAs(User::factory()->create());
        $product = $this->product();
        $order = $this->order($product);

        $this->delete("/data-hub/products/{$product->id}");

        $item = $order->items()->first();
        $this->assertNotNull($item);
        $this->assertNull($item->product_id);
        $this->assertSame('Oyster Tube', $item->product_name);
        $this->get("/data-hub/orders/{$order->id}")->assertOk()->assertSee('Oyster Tube');
    }

    // ---------- Orders ----------

    public function test_orders_list_filters_and_detail(): void
    {
        $this->actingAs(User::factory()->create());
        $p = $this->product();
        $a = $this->order($p, 1, 'pending');
        $b = $this->order($p, 1, 'completed');

        $this->get('/data-hub/orders?status=completed')->assertSee($b->order_number)->assertDontSee($a->order_number);
        $this->get('/data-hub/orders?q='.$a->order_number)->assertSee($a->order_number)->assertDontSee($b->order_number);
        $this->get('/data-hub/orders?sort=total&dir=asc')->assertOk();
        $this->get("/data-hub/orders/{$a->id}")->assertOk()->assertSee($a->order_number);
    }

    public function test_cancelling_and_reopening_an_order_keeps_stock_consistent(): void
    {
        $this->actingAs(User::factory()->create());
        $product = $this->product(['stock' => 10]);
        $order = $this->order($product, 4, 'pending');   // (stock not decremented by the helper; start at 10)

        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'cancelled'])->assertRedirect();
        $this->assertSame(14, $product->fresh()->stock);

        // cancelling twice must not restock twice
        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'cancelled']);
        $this->assertSame(14, $product->fresh()->stock);

        // re-opening reserves the stock again
        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'processing'])->assertSessionDoesntHaveErrors();
        $this->assertSame(10, $product->fresh()->stock);
        $this->assertSame('processing', $order->fresh()->status);

        // non-cancel transitions never touch stock
        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'shipped']);
        $this->assertSame(10, $product->fresh()->stock);
    }

    public function test_reopening_a_cancelled_order_fails_when_stock_is_insufficient(): void
    {
        $this->actingAs(User::factory()->create());
        $product = $this->product(['stock' => 1]);
        $order = $this->order($product, 5, 'cancelled');

        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'pending'])->assertSessionHasErrors('status');
        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_invalid_order_status_is_rejected(): void
    {
        $this->actingAs(User::factory()->create());
        $order = $this->order($this->product());

        $this->patch("/data-hub/orders/{$order->id}/status", ['status' => 'bogus'])->assertSessionHasErrors('status');
        $this->assertSame('pending', $order->fresh()->status);
    }

    // ---------- Record forms (public + staff) ----------

    public function test_record_forms_validate_and_store(): void
    {
        $this->post('/forms/sales', ['customer_name' => 'X', 'product_line' => 'Y', 'payment_status' => 'bogus'])->assertSessionHasErrors('payment_status');
        $this->post('/forms/sales', ['customer_name' => 'X', 'product_line' => 'Y', 'payment_status' => 'paid', 'amount' => 3])->assertRedirect('/forms/sales');
        $this->assertDatabaseHas('sales_records', ['customer_name' => 'X']);

        $this->post('/forms/dmms', ['farm_name' => 'F', 'recorded_at' => now()->toDateTimeString(), 'humidity_pct' => 120])->assertSessionHasErrors('humidity_pct');
        $this->post('/forms/incubation', ['batch_reference' => 'B', 'species' => 'S', 'incubation_start' => '2026-05-10', 'expected_fruit' => '2026-05-01'])
            ->assertSessionHasErrors('expected_fruit');
    }

    public function test_every_dashboard_page_renders_for_staff(): void
    {
        $this->actingAs(User::factory()->create());
        $p = $this->product();
        $o = $this->order($p);

        foreach (['/data-hub', '/data-hub/orders', "/data-hub/orders/{$o->id}", '/data-hub/products', '/data-hub/products/create',
            "/data-hub/products/{$p->id}/edit", '/data-hub/contacts/create', '/forms', '/forms/purchase', '/forms/sales', '/forms/dmms', '/forms/incubation',
            ...array_map(fn ($m) => "/data-hub/module/$m", ['purchases', 'sales', 'dmms', 'incubation', 'contacts'])] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
