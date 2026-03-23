@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Purchase form')

@section('content')
    @php
        $hub = auth()->check();
    @endphp
    <div class="mx-auto max-w-2xl @unless($hub) px-4 py-12 sm:px-6 lg:px-8 @endunless">
        <a href="{{ $hub ? route('data-hub.module', ['module' => 'purchases']) : route('forms.hub') }}" class="text-sm font-medium {{ $hub ? 'text-damson-orange hover:text-damson-orange-hover' : 'text-stone-500 hover:text-stone-900' }}">← {{ $hub ? 'Purchase list' : 'Forms' }}</a>
        <div class="mt-6 {{ $hub ? 'dashboard-card p-6 sm:p-8' : 'rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm sm:p-8' }}">
            <h1 class="font-display text-xl font-semibold text-stone-900">Purchase</h1>
            <p class="mt-2 text-sm text-stone-600">Log interest in tubes, spawn, or DMMS hardware for our team to follow up.</p>
            <form action="{{ route('forms.purchase.store') }}" method="post" class="mt-6 space-y-4">
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
                    <label class="block text-sm font-medium text-stone-700" for="product_interest">Product interest</label>
                    <input class="damson-input" type="text" name="product_interest" id="product_interest" value="{{ old('product_interest') }}" placeholder="e.g. Oyster tubes, shiitake spawn" required>
                    @error('product_interest')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="quantity">Quantity</label>
                        <input class="damson-input" type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="unit">Unit</label>
                        <input class="damson-input" type="text" name="unit" id="unit" value="{{ old('unit') }}" placeholder="bags, kg, units">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="notes">Notes</label>
                    <textarea class="damson-input" name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
                <button class="damson-btn w-full" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
