@props(['status', 'label' => null])

@php
    $variant = match ($status) {
        'completed', 'paid', 'accepted' => 'success',
        'processing', 'shipped', 'contacted' => 'info',
        'pending', 'partial', 'new' => 'warning',
        'cancelled', 'declined' => 'danger',
        default => 'neutral',
    };
@endphp
<span class="badge badge-{{ $variant }}">{{ $label ?? ucfirst((string) $status) }}</span>
