<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function staff(): User
    {
        $u = User::factory()->create();
        $u->role = 'staff';
        $u->save();

        return $u;
    }

    public function test_existing_style_users_default_to_admin(): void
    {
        $this->assertTrue(User::factory()->create()->fresh()->isAdmin());
    }

    public function test_guests_are_redirected_and_staff_are_forbidden_on_the_backend(): void
    {
        $target = $this->staff();

        $this->get('/data-hub/users')->assertRedirect('/login');

        $this->actingAs($target);
        foreach ([['get', '/data-hub/users'], ['get', '/data-hub/users/create'], ['post', '/data-hub/users'],
            ['get', "/data-hub/users/{$target->id}/edit"], ['put', "/data-hub/users/{$target->id}"], ['delete', "/data-hub/users/{$target->id}"]] as [$m, $u]) {
            $this->{$m}($u, $m === 'post' ? ['name' => 'x', 'email' => 'x@x.com', 'role' => 'admin', 'password' => 'password1', 'password_confirmation' => 'password1'] : [])->assertForbidden();
        }
        $this->assertSame(0, User::query()->where('email', 'x@x.com')->count());
        // staff still use the rest of the dashboard, but do not see the Users link
        $this->get('/data-hub')->assertOk()->assertDontSee('/data-hub/users');
    }

    public function test_staff_cannot_promote_themselves(): void
    {
        $staff = $this->staff();
        $this->actingAs($staff)->put("/data-hub/users/{$staff->id}", ['name' => $staff->name, 'email' => $staff->email, 'role' => 'admin'])->assertForbidden();
        $this->assertSame('staff', $staff->fresh()->role);
    }

    public function test_admin_can_create_edit_and_delete_users(): void
    {
        $this->actingAs($this->admin());

        $this->post('/data-hub/users', ['name' => '', 'email' => 'bad', 'role' => 'root', 'password' => 'short'])->assertSessionHasErrors(['name', 'email', 'role', 'password']);

        $this->post('/data-hub/users', ['name' => 'Eve', 'email' => 'eve@damson.test', 'role' => 'staff', 'password' => 'password1', 'password_confirmation' => 'password1'])
            ->assertRedirect('/data-hub/users');
        $eve = User::query()->where('email', 'eve@damson.test')->firstOrFail();
        $this->assertSame('staff', $eve->role);
        $this->assertNotSame('password1', $eve->password);

        $this->post('/data-hub/users', ['name' => 'Dup', 'email' => 'eve@damson.test', 'role' => 'staff', 'password' => 'password1', 'password_confirmation' => 'password1'])->assertSessionHasErrors('email');

        $hash = $eve->password;
        $this->put("/data-hub/users/{$eve->id}", ['name' => 'Eve B', 'email' => 'eve@damson.test', 'role' => 'admin'])->assertRedirect('/data-hub/users');
        $this->assertSame('Eve B', $eve->fresh()->name);
        $this->assertTrue($eve->fresh()->isAdmin());
        $this->assertSame($hash, $eve->fresh()->password);   // blank password keeps the old one

        $this->put("/data-hub/users/{$eve->id}", ['name' => 'Eve B', 'email' => 'eve@damson.test', 'role' => 'admin', 'password' => 'newpassword1', 'password_confirmation' => 'newpassword1']);
        $this->assertNotSame($hash, $eve->fresh()->password);

        $this->get('/data-hub/users?q=eve&role=admin')->assertOk()->assertSee('Eve B');
        $this->delete("/data-hub/users/{$eve->id}")->assertRedirect('/data-hub/users');
        $this->assertDatabaseMissing('users', ['id' => $eve->id]);
    }

    public function test_cannot_delete_self_or_remove_the_last_admin(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);

        $this->delete("/data-hub/users/{$admin->id}")->assertSessionHasErrors('user');
        $this->put("/data-hub/users/{$admin->id}", ['name' => $admin->name, 'email' => $admin->email, 'role' => 'staff'])->assertSessionHasErrors('role');
        $this->assertTrue($admin->fresh()->isAdmin());

        // a second admin can be demoted, and then can no longer be deleted as "last admin" issue does not arise
        $other = $this->admin();
        $this->put("/data-hub/users/{$other->id}", ['name' => $other->name, 'email' => $other->email, 'role' => 'staff'])->assertRedirect();
        $this->assertSame('staff', $other->fresh()->role);
    }

    public function test_cancelling_an_order_asks_for_confirmation(): void
    {
        $this->actingAs($this->admin());
        $order = \App\Models\Order::query()->create([
            'order_number' => 'DM-X', 'status' => 'pending', 'payment_method' => 'cash_on_delivery', 'customer_name' => 'J',
            'customer_email' => 'j@x.com', 'shipping_address' => 'K', 'subtotal' => 1, 'total' => 1,
        ]);
        $this->get("/data-hub/orders/{$order->id}")->assertSee('Cancel this order?', false);
    }
}
