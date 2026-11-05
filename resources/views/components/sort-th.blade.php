@props(['column', 'label', 'sort', 'dir', 'right' => false])

@php
    $active = $sort === $column;
    $next = $active && $dir === 'asc' ? 'desc' : 'asc';
    $url = request()->fullUrlWithQuery(['sort' => $column, 'dir' => $next, 'page' => null]);
@endphp
<th scope="col" class="{{ $right ? 'is-right' : '' }}" aria-sort="{{ $active ? ($dir === 'asc' ? 'ascending' : 'descending') : 'none' }}">
    <a href="{{ $url }}" class="group inline-flex items-center gap-1 uppercase tracking-wide transition hover:text-brand-900 {{ $active ? 'text-brand-900' : '' }}">
        {{ $label }}
        <svg class="h-3.5 w-3.5 {{ $active ? 'opacity-100' : 'opacity-0 group-hover:opacity-50' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            @if ($active && $dir === 'asc')<path d="M10 5l5 7H5l5-7z"/>@else<path d="M10 15l-5-7h10l-5 7z"/>@endif
        </svg>
    </a>
</th>
