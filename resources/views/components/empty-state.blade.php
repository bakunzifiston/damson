@props(['title', 'text' => null])

<div class="px-6 py-14 text-center">
    <svg class="mx-auto h-10 w-10 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0h-4.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 008.586 13H4"/></svg>
    <p class="mt-3 text-sm font-semibold text-stone-800">{{ $title }}</p>
    @if ($text)<p class="mt-1 text-sm text-stone-500">{{ $text }}</p>@endif
    @if (! $slot->isEmpty())<div class="mt-4">{{ $slot }}</div>@endif
</div>
