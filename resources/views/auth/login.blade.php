@extends('layouts.site')

@section('title', 'Staff login')

@section('content')
    <div class="mx-auto flex min-h-[70vh] max-w-md flex-col justify-center px-4 py-12 sm:px-6">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="" width="56" height="56" class="mx-auto h-14 w-14 rounded-full object-cover ring-2 ring-brand-900/10">
            <h1 class="mt-4 font-display text-2xl font-semibold tracking-tight text-brand-950">Staff sign in</h1>
            <p class="mt-1 text-sm text-stone-600">Access the DAMSON dashboard.</p>
        </div>
        <form action="{{ route('login.store') }}" method="post" class="dashboard-card mt-6 space-y-5 p-6 sm:p-8">
            @csrf
            <x-field name="email" label="Email" type="email" required autofocus autocomplete="username" />
            <x-field name="password" label="Password" type="password" required autocomplete="current-password" />
            <label class="flex items-center gap-2.5 text-sm text-stone-700">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-stone-300">
                Remember me
            </label>
            <button class="damson-btn w-full" type="submit">Sign in</button>
        </form>
        <p class="mt-4 text-center text-xs text-stone-500">Demo: admin@damson.test / password</p>
    </div>
@endsection
