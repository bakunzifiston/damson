@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'help' => null,
    'optional' => false,
    'rows' => 3,
])

@php
    $id = $attributes->get('id', $name);
    $describedBy = collect([$errors->has($name) ? $id.'-error' : null, $help ? $id.'-help' : null])->filter()->implode(' ');
    $inputAttrs = $attributes->except(['id', 'class'])->merge([
        'id' => $id,
        'name' => $name,
        'aria-invalid' => $errors->has($name) ? 'true' : null,
        'aria-describedby' => $describedBy ?: null,
    ]);
@endphp

<div {{ $attributes->only('class') }}>
    <label class="damson-label" for="{{ $id }}">
        {{ $label }}
        @if ($optional)<span class="font-normal text-stone-400">(optional)</span>@endif
    </label>
    @if ($type === 'textarea')
        <textarea {{ $inputAttrs->merge(['rows' => $rows, 'class' => 'damson-input']) }} @required($required)>{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select {{ $inputAttrs->merge(['class' => 'damson-input']) }} @required($required)>{{ $slot }}</select>
    @else
        <input type="{{ $type }}" value="{{ $type === 'password' ? '' : old($name, $value) }}" {{ $inputAttrs->merge(['class' => 'damson-input']) }} @required($required)>
    @endif
    @if ($help)<p id="{{ $id }}-help" class="damson-help">{{ $help }}</p>@endif
    @error($name)<p id="{{ $id }}-error" class="damson-error">{{ $message }}</p>@enderror
</div>
