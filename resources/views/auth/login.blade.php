@extends('layouts.site')

@section('title', 'Staff login')

@section('content')
    <div class="mx-auto flex min-h-[60vh] max-w-md flex-col justify-center px-4 py-16 sm:px-6">
        <div class="rounded-2xl border border-brand-900/12 bg-damson-panel p-8 shadow-sm">
            <h1 class="font-display text-xl font-semibold text-stone-900">Staff login</h1>
            <p class="mt-2 text-xs text-stone-500">Demo: admin@damson.test / password</p>
            <form action="{{ route('login.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="email">Email</label>
                    <input class="damson-input" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="password">Password</label>
                    <input class="damson-input" type="password" name="password" id="password" required autocomplete="current-password">
                </div>
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="remember" value="1" class="rounded border-stone-300 text-brand-700 focus:ring-brand-500">
                    Remember me
                </label>
                <button class="damson-btn w-full" type="submit">Sign in</button>
            </form>
        </div>
    </div>
@endsection
