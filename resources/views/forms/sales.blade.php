@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Sales record')

@section('content')
    @php $hub = auth()->check(); @endphp
    <x-form-page :hub="$hub" title="Sales" intro="Track outbound sales for reporting and reconciliation."
                 :back-url="$hub ? route('data-hub.module', 'sales') : route('forms.hub')"
                 :back-label="$hub ? 'Sales list' : 'All forms'">
        <form action="{{ route('forms.sales.store') }}" method="post" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="customer_name" label="Customer name" required />
                <x-field name="email" label="Customer email" type="email" optional />
                <x-field name="product_line" label="Product line" required />
                <x-field name="amount" label="Amount" type="number" step="0.01" optional />
                <x-field name="payment_status" label="Payment status" type="select" optional>
                    <option value="">—</option>
                    @foreach (['pending' => 'Pending', 'partial' => 'Partial', 'paid' => 'Paid'] as $v => $l)
                        <option value="{{ $v }}" @selected(old('payment_status') === $v)>{{ $l }}</option>
                    @endforeach
                </x-field>
            </div>
            <x-field name="notes" label="Notes" type="textarea" optional />
            <button class="damson-btn w-full sm:w-auto" type="submit">Save</button>
        </form>
    </x-form-page>
@endsection
