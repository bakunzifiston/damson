@props([
    'title',
    'intro' => null,
    'backUrl',
    'backLabel',
    'hub' => false,
])

{{-- Shared shell for forms that render inside the staff dashboard or the public site. --}}
<div class="mx-auto max-w-2xl {{ $hub ? '' : 'px-4 py-12 sm:px-6 lg:px-8' }}">
    <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-stone-600 transition hover:text-brand-900">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd"/></svg>
        {{ $backLabel }}
    </a>
    <div class="dashboard-card mt-4 p-6 sm:p-8">
        <h1 class="font-display text-2xl font-semibold tracking-tight text-brand-950">{{ $title }}</h1>
        @if ($intro)<p class="mt-2 text-sm text-stone-600">{{ $intro }}</p>@endif
        <div class="mt-6">
            {{ $slot }}
        </div>
    </div>
</div>
