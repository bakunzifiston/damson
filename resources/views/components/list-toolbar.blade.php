@props(['placeholder' => 'Search…', 'exportUrl' => null])

{{-- GET filter bar: search box + optional extra filters (slot) + reset. Sort order is preserved. --}}
<form method="get" action="{{ url()->current() }}" class="flex flex-col gap-3 border-b border-stone-200 p-4 sm:flex-row sm:flex-wrap sm:items-end" role="search">
    @foreach (['sort', 'dir'] as $keep)
        @if (request()->filled($keep))<input type="hidden" name="{{ $keep }}" value="{{ request($keep) }}">@endif
    @endforeach
    <div class="min-w-0 flex-1 sm:min-w-[14rem]">
        <label for="q" class="sr-only">Search</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}" maxlength="100" class="damson-input !mt-0 !pl-9">
        </div>
    </div>
    {{ $slot }}
    <div class="flex items-center gap-2">
        <button type="submit" class="damson-btn">Apply</button>
        @if (collect(request()->except(['page', 'sort', 'dir']))->filter(fn ($v) => $v !== null && $v !== '')->isNotEmpty())
            <a href="{{ url()->current() }}" class="damson-btn-ghost">Reset</a>
        @endif
        @if ($exportUrl)
            <a href="{{ $exportUrl }}" class="damson-btn-outline">Export CSV</a>
        @endif
    </div>
</form>
