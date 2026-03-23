@extends('layouts.site')

@section('title', 'Contact & support')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-16">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                <h1 class="font-display text-3xl font-semibold text-stone-900">Contact</h1>
                <p class="mt-3 text-sm text-stone-500 leading-relaxed">We usually reply within one business day.</p>
                @php $c = config('damson.contact'); @endphp
                <ul class="mt-8 space-y-4 text-sm">
                    <li>
                        <span class="font-semibold text-stone-900">Email</span><br>
                        <a href="mailto:{{ $c['email'] }}" class="font-medium text-damson-orange hover:text-damson-orange-hover">{{ $c['email'] }}</a>
                    </li>
                    <li>
                        <span class="font-semibold text-stone-900">Phone</span><br>
                        <a href="tel:{{ preg_replace('/\s+/', '', $c['phone']) }}" class="font-medium text-damson-orange hover:text-damson-orange-hover">{{ $c['phone'] }}</a>
                    </li>
                    <li>
                        <span class="font-semibold text-stone-900">Address</span><br>
                        <span class="text-stone-600">{{ $c['address'] }}</span>
                    </li>
                </ul>
            </div>
            <div class="rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm lg:p-8">
                <h2 class="text-sm font-medium text-stone-900">Message</h2>
                <form action="{{ route('contact.store') }}" method="post" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-stone-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="damson-input">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="damson-input">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-stone-700">Phone (optional)</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="damson-input">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-stone-700">Subject (optional)</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject', request('subject')) }}" class="damson-input">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-stone-700">Message</label>
                        <textarea name="message" id="message" rows="5" required class="damson-input">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="damson-btn w-full">Send</button>
                </form>
            </div>
        </div>
    </div>
@endsection
