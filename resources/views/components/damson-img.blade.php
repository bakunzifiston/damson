@props([
    'path',
    'alt' => '',
])

<img src="{{ \App\Support\DamsonAssets::image($path) }}" alt="{{ $alt }}" {{ $attributes }}>
