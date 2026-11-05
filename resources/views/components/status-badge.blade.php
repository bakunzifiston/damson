@props(['status', 'label' => null])

@php
    $variant = match ($status) {
        'completed', 'paid' => 'success',
        'processing', 'shipped' => 'info',
        'pending', 'partial' => 'warning',
        'cancelled' => 'danger',
        default => 'neutral',
    };
@endphp
<span class="badge badge-{{ $variant }}">{{ $label ?? ucfirst((string) $status) }}</span>
