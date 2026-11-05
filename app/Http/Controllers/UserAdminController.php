<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/** Staff account management. Access is restricted to admins by the "manage-users" gate on the routes. */
class UserAdminController extends Controller
{
    use FiltersLists;

    public function index(Request $request): View
    {
        $query = User::query();
        $this->applySearch($query, $request->query('q'), ['name', 'email']);
        if (in_array($request->query('role'), User::ROLES, true)) {
            $query->where('role', $request->query('role'));
        }
        [$sort, $dir] = $this->applySort($query, $request, ['name', 'email', 'role', 'created_at'], 'name', 'asc');

        return view('data-hub.users.index', [
            'users' => $query->paginate(20)->withQueryString(),
            'roles' => User::ROLES, 'sort' => $sort, 'dir' => $dir,
        ]);
    }

    public function create(): View
    {
        return view('data-hub.users.form', ['user' => new User, 'roles' => User::ROLES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(User::ROLES)],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = new User(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password']]);
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('data-hub.users.index')->with('status', 'User created.');
    }

    public function edit(User $user): View
    {
        return view('data-hub.users.form', ['user' => $user, 'roles' => User::ROLES]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(User::ROLES)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        if ($user->isAdmin() && $data['role'] !== User::ROLE_ADMIN && $this->isLastAdmin($user)) {
            return back()->withInput()->withErrors(['role' => 'At least one admin account must remain.']);
        }

        $user->fill(['name' => $data['name'], 'email' => $data['email']]);
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('data-hub.users.index')->with('status', 'User updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }
        if ($user->isAdmin() && $this->isLastAdmin($user)) {
            return back()->withErrors(['user' => 'At least one admin account must remain.']);
        }

        $user->delete();

        return redirect()->route('data-hub.users.index')->with('status', 'User deleted.');
    }

    private function isLastAdmin(User $user): bool
    {
        return ! User::query()->where('role', User::ROLE_ADMIN)->where('id', '!=', $user->id)->exists();
    }
}
