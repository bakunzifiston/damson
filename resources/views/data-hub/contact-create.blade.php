@extends('layouts.dashboard')

@section('title', 'Add contact message')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('data-hub.module', ['module' => 'contacts']) }}" class="text-sm font-medium text-damson-orange hover:text-damson-orange-hover">← Contact messages</a>

        <div class="dashboard-card mt-6 p-6 sm:p-8">
            <h1 class="font-display text-xl font-semibold text-brand-950">Add message</h1>
            <p class="mt-2 text-sm text-stone-600">Log an inquiry or internal note in the same inbox as the public contact form.</p>

            <form action="{{ route('data-hub.contacts.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="name">Name</label>
                    <input class="damson-input" type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="email">Email</label>
                    <input class="damson-input" type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="phone">Phone</label>
                    <input class="damson-input" type="text" name="phone" id="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="subject">Subject</label>
                    <input class="damson-input" type="text" name="subject" id="subject" value="{{ old('subject') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="message">Message</label>
                    <textarea class="damson-input" name="message" id="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-wrap gap-3 pt-2">
                    <button class="damson-btn rounded-xl" type="submit">Save message</button>
                    <a href="{{ route('data-hub.module', ['module' => 'contacts']) }}" class="damson-btn-outline rounded-xl">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
