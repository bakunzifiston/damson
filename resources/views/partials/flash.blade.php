@php
    $inset = $inset ?? false;
    $wrap = $inset ? 'mb-6 rounded-lg border' : 'border-b';
@endphp
@if ($errors->any())
    <div class="{{ $wrap }} border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
        <div class="{{ $inset ? '' : 'mx-auto max-w-5xl' }}">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if (session('status'))
    <div class="{{ $wrap }} border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900" role="status">
        <div class="{{ $inset ? '' : 'mx-auto max-w-5xl' }}">{{ session('status') }}</div>
    </div>
@endif
@if (session('error'))
    <div class="{{ $wrap }} border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
        <div class="{{ $inset ? '' : 'mx-auto max-w-5xl' }}">{{ session('error') }}</div>
    </div>
@endif
