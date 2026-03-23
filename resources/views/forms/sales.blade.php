@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Sales record')

@section('content')
    @php
        $hub = auth()->check();
    @endphp
    <div class="mx-auto max-w-2xl @unless($hub) px-4 py-12 sm:px-6 lg:px-8 @endunless">
        <a href="{{ $hub ? route('data-hub.module', ['module' => 'sales']) : route('forms.hub') }}" class="text-sm font-medium {{ $hub ? 'text-damson-orange hover:text-damson-orange-hover' : 'text-stone-500 hover:text-stone-900' }}">← {{ $hub ? 'Sales list' : 'Forms' }}</a>
        <div class="mt-6 {{ $hub ? 'dashboard-card p-6 sm:p-8' : 'rounded-2xl border border-brand-900/12 bg-damson-panel p-6 shadow-sm sm:p-8' }}">
            <h1 class="font-display text-xl font-semibold text-stone-900">Sales</h1>
            <p class="mt-2 text-sm text-stone-600">Track outbound sales for reporting and reconciliation.</p>
            <form action="{{ route('forms.sales.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="customer_name">Customer name</label>
                    <input class="damson-input" type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required>
                    @error('customer_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="email">Customer email</label>
                    <input class="damson-input" type="email" name="email" id="email" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="product_line">Product line</label>
                    <input class="damson-input" type="text" name="product_line" id="product_line" value="{{ old('product_line') }}" required>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="amount">Amount</label>
                        <input class="damson-input" type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700" for="payment_status">Payment status</label>
                        <select class="damson-input" name="payment_status" id="payment_status">
                            <option value="">—</option>
                            <option value="pending" @selected(old('payment_status') === 'pending')>Pending</option>
                            <option value="partial" @selected(old('payment_status') === 'partial')>Partial</option>
                            <option value="paid" @selected(old('payment_status') === 'paid')>Paid</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700" for="notes">Notes</label>
                    <textarea class="damson-input" name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
                <button class="damson-btn w-full" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
