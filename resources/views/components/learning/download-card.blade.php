@props(['item'])

{{-- A downloadable resource. The whole card is one link that opens the document directly (PDFs open in the browser viewer). --}}
@php $url = $item->open_url; @endphp

@if ($url)
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
       class="group flex h-full gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-brand-300 hover:shadow-md">
@else
    <div class="flex h-full gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm opacity-80">
@endif
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-800" aria-hidden="true">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </span>
        <span class="flex min-w-0 flex-1 flex-col">
            <span class="flex flex-wrap items-center gap-2">
                @if ($item->format)<span class="badge badge-neutral uppercase">{{ $item->format }}</span>@endif
                @if ($item->category)<span class="text-xs font-medium uppercase tracking-wide text-stone-500">{{ $item->category }}</span>@endif
            </span>
            <span class="mt-2 font-display text-base font-semibold text-brand-950 {{ $url ? 'group-hover:text-brand-700' : '' }}">{{ $item->title }}</span>
            @if ($item->excerpt)<span class="mt-1 line-clamp-2 text-sm text-stone-600">{{ $item->excerpt }}</span>@endif
            <span class="mt-3 text-sm font-medium {{ $url ? 'text-brand-700 group-hover:text-damson-orange' : 'text-stone-400' }}">
                @if ($url)Open document <span aria-hidden="true">↗</span><span class="sr-only">(opens in a new tab)</span>@else Not available yet @endif
            </span>
        </span>
@if ($url)
    </a>
@else
    </div>
@endif
