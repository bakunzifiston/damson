@props(['categories', 'active' => null, 'filterable' => false, 'label' => 'Filter by category'])

{{-- Category tabs. Each tab is a real link (works without JavaScript); with $filterable a small script filters the cards in place. --}}
<div class="flex flex-wrap gap-2" role="group" aria-label="{{ $label }}" @if ($filterable) data-category-tabs @endif>
    @foreach ([null => 'All'] + $categories->all() as $cat => $n)
        @php
            $value = $cat === '' || $cat === 0 ? null : $cat;
            $isActive = ($active ?: null) === $value;
            $text = $value ?? 'All';
            $count = $value === null ? $categories->sum() : $n;
        @endphp
        <a href="{{ route('learning.resources', array_filter(['type' => 'download', 'category' => $value])) }}"
           @if ($isActive) aria-current="true" @endif data-tab-value="{{ $value }}"
           class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition {{ $isActive ? 'border-brand-900 bg-brand-900 text-white' : 'border-stone-300 bg-white text-stone-700 hover:border-brand-900' }}">
            {{ $text }} <span class="{{ $isActive ? 'text-white/70' : 'text-stone-400' }}" data-tab-count>{{ $count }}</span>
        </a>
    @endforeach
</div>
