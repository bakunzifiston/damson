@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.site')

@section('title', 'Purchase form')

@section('content')
    @php $hub = auth()->check(); @endphp
    <x-form-page :hub="$hub" title="Purchase" intro="Log interest in tubes, spawn, or DMMS hardware for our team to follow up."
                 :back-url="$hub ? route('data-hub.module', 'purchases') : route('forms.hub')"
                 :back-label="$hub ? 'Purchase list' : 'All forms'">
        <form action="{{ route('forms.purchase.store') }}" method="post" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="name" label="Name" required />
                <x-field name="email" label="Email" type="email" required />
                <x-field name="phone" label="Phone" optional />
                <x-field name="product_interest" label="Product interest" placeholder="e.g. Oyster tubes, shiitake spawn" required />
                <x-field name="quantity" label="Quantity" type="number" min="1" optional />
                <x-field name="unit" label="Unit" placeholder="bags, kg, units" optional />
            </div>
            <x-field name="notes" label="Notes" type="textarea" optional />
            <button class="damson-btn w-full sm:w-auto" type="submit">Save</button>
        </form>
    </x-form-page>
@endsection
