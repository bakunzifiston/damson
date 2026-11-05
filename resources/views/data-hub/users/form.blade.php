@extends('layouts.dashboard')

@php $editing = $user->exists; @endphp

@section('title', $editing ? 'Edit user' : 'Add user')

@section('content')
    <div class="mx-auto max-w-2xl">
        <x-dash-header :title="$editing ? 'Edit user' : 'Add user'" :crumbs="[['label' => 'Users', 'url' => route('data-hub.users.index')], ['label' => $editing ? 'Edit' : 'New']]" />

        <form action="{{ $editing ? route('data-hub.users.update', $user) : route('data-hub.users.store') }}" method="post" class="dashboard-card mt-6 space-y-5 p-6 sm:p-8">
            @csrf
            @if ($editing) @method('PUT') @endif
            <x-field name="name" label="Name" :value="$user->name" required autocomplete="off" />
            <x-field name="email" label="Email" type="email" :value="$user->email" required autocomplete="off" />
            <x-field name="role" label="Role" type="select" required help="Admins can also manage user accounts.">
                @foreach ($roles as $r)<option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}</option>@endforeach
            </x-field>
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="password" label="{{ $editing ? 'New password' : 'Password' }}" type="password" :required="! $editing" :optional="$editing" autocomplete="new-password" help="At least 8 characters." />
                <x-field name="password_confirmation" label="Confirm password" type="password" :required="! $editing" autocomplete="new-password" />
            </div>
            <div class="flex flex-wrap gap-3 pt-1">
                <button type="submit" class="damson-btn">{{ $editing ? 'Save changes' : 'Create user' }}</button>
                <a href="{{ route('data-hub.users.index') }}" class="damson-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
