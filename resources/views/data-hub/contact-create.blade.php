@extends('layouts.dashboard')

@section('title', 'Add message')

@section('content')
    <div class="mx-auto max-w-2xl">
        <x-dash-header title="Add message" subtitle="Log an inquiry or internal note in the same inbox as the public contact form."
                       :crumbs="[['label' => 'Messages', 'url' => route('data-hub.module', 'contacts')], ['label' => 'New']]" />

        <form action="{{ route('data-hub.contacts.store') }}" method="post" class="dashboard-card mt-6 space-y-5 p-6 sm:p-8">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field name="name" label="Name" required />
                <x-field name="email" label="Email" type="email" required />
                <x-field name="phone" label="Phone" optional />
                <x-field name="subject" label="Subject" optional />
            </div>
            <x-field name="message" label="Message" type="textarea" :rows="5" required />
            <div class="flex flex-wrap gap-3 pt-1">
                <button class="damson-btn" type="submit">Save message</button>
                <a href="{{ route('data-hub.module', 'contacts') }}" class="damson-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
