@props(['name', 'class' => 'h-6 w-6'])

@php
    $icons = [
        'eye' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3" stroke-width="1.75"/>',
        'target' => '<circle cx="12" cy="12" r="10" stroke-width="1.75"/><circle cx="12" cy="12" r="6" stroke-width="1.75"/><circle cx="12" cy="12" r="2" stroke-width="1.75"/>',
        'calendar' => '<rect width="18" height="18" x="3" y="4" rx="2" stroke-width="1.75"/><path stroke-linecap="round" stroke-width="1.75" d="M16 2v4M8 2v4M3 10h18"/>',
        'users' => '<path stroke-linecap="round" stroke-width="1.75" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4" stroke-width="1.75"/><path stroke-linecap="round" stroke-width="1.75" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        'package' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m7.5 4.27 9 5.15M21 8.25v7.5L12 21 3 15.75v-7.5l9-5.15M3.75 8.25 12 13.5l8.25-5.25M12 13.5V21"/>',
        'sprout' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 20h10M12 20V10M12 10C12 6 8 4 5 6c0 4 3 4 7 4M12 10c0-4 4-6 7-4-1 4-4 4-7 4"/><path stroke-linecap="round" stroke-width="1.75" d="M12 20V14"/>',
        'book' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
        'cpu' => '<rect width="16" height="16" x="4" y="4" rx="2" stroke-width="1.75"/><path stroke-linecap="round" stroke-width="1.75" d="M9 9h6v6H9zM9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3"/>',
        'handshake' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m11 17 2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0 0-1.414l-2-2M7 13l-2-2a1 1 0 0 1 0-1.414l4-4a1 1 0 0 1 1.414 0l2 2M3 21l3-3M21 3l-3 3"/>',
        'award' => '<circle cx="12" cy="8" r="6" stroke-width="1.75"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
        'leaf' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
        'lightbulb' => '<path stroke-linecap="round" stroke-width="1.75" d="M9 18h6M10 22h4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2z"/>',
        'chart' => '<path stroke-linecap="round" stroke-width="1.75" d="M3 3v18h18"/><path stroke-linecap="round" stroke-width="1.75" d="m19 9-5 5-4-4-3 3"/>',
        'quote' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 21c3 0 7-1 7-8V5H3v14ZM14 21c3 0 7-1 7-8V5h-7v14Z"/>',
        'chevron-left' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/>',
        'chevron-right' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6"/>',
        'mail' => '<rect width="20" height="16" x="2" y="4" rx="2" stroke-width="1.75"/><path stroke-linecap="round" stroke-width="1.75" d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'flask' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 2v6.5L4.5 18a2 2 0 0 0 1.7 3h11.6a2 2 0 0 0 1.7-3L14 8.5V2"/><path stroke-linecap="round" stroke-width="1.75" d="M8.5 2h7M9 14h6"/>',
    ];
    $path = $icons[$name] ?? $icons['sprout'];
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
    {!! $path !!}
</svg>
