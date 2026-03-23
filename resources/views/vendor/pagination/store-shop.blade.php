@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-wrap items-center justify-center gap-2 pt-12">
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm text-stone-300" aria-disabled="true">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm font-semibold text-damson-orange shadow-sm transition hover:border-damson-orange/40 hover:bg-damson-orange-muted" aria-label="{{ __('pagination.previous') }}">‹</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-sm text-stone-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-damson-orange text-sm font-bold text-white shadow-md ring-2 ring-damson-orange/30">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm font-semibold text-damson-orange shadow-sm transition hover:border-damson-orange/40 hover:bg-damson-orange-muted" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm font-semibold text-damson-orange shadow-sm transition hover:border-damson-orange/40 hover:bg-damson-orange-muted" aria-label="{{ __('pagination.next') }}">›</a>
        @else
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm text-stone-300" aria-disabled="true">›</span>
        @endif
    </nav>
@endif
