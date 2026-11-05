@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <div class="mx-auto max-w-6xl">
        <x-dash-header title="Users" subtitle="Admins can manage everything, including accounts. Staff can manage records, products, orders and content." :crumbs="[['label' => 'Users']]">
            <x-slot:actions>
                <a href="{{ route('data-hub.users.create') }}" class="damson-btn-accent">Add user</a>
            </x-slot:actions>
        </x-dash-header>

        <div class="dashboard-card mt-6 overflow-hidden">
            <x-list-toolbar placeholder="Search name or email…">
                <div>
                    <label for="role" class="sr-only">Role</label>
                    <select id="role" name="role" class="damson-input !mt-0">
                        <option value="">All roles</option>
                        @foreach ($roles as $r)<option value="{{ $r }}" @selected(request('role') === $r)>{{ ucfirst($r) }}</option>@endforeach
                    </select>
                </div>
            </x-list-toolbar>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <x-sort-th column="name" label="Name" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="email" label="Email" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="role" label="Role" :sort="$sort" :dir="$dir" />
                            <x-sort-th column="created_at" label="Added" :sort="$sort" :dir="$dir" />
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr>
                                <td class="font-medium text-stone-900">{{ $u->name }} @if ($u->is(auth()->user()))<span class="badge badge-neutral ml-1">You</span>@endif</td>
                                <td>{{ $u->email }}</td>
                                <td><span class="badge {{ $u->isAdmin() ? 'badge-info' : 'badge-neutral' }}">{{ ucfirst($u->role) }}</span></td>
                                <td class="whitespace-nowrap text-stone-600">{{ $u->created_at?->format('M j, Y') }}</td>
                                <td class="whitespace-nowrap text-right">
                                    <a href="{{ route('data-hub.users.edit', $u) }}" class="damson-btn-outline damson-btn-sm">Edit<span class="sr-only"> {{ $u->name }}</span></a>
                                    @unless ($u->is(auth()->user()))
                                        <form action="{{ route('data-hub.users.destroy', $u) }}" method="post" class="ml-1 inline" onsubmit="return confirm('Delete {{ e(addslashes($u->name)) }}? They will lose access immediately.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="damson-btn-danger damson-btn-sm">Delete<span class="sr-only"> {{ $u->name }}</span></button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><x-empty-state title="No users found" text="Try a different search." /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())<div class="border-t border-stone-200 bg-stone-50 px-4 py-3">{{ $users->links() }}</div>@endif
        </div>
    </div>
@endsection
