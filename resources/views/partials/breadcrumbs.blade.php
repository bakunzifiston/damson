@props(['items' => []])

@if (count($items) > 0)
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-brand-100/85">
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    @if (! $loop->first)
                        <span class="text-brand-100/50" aria-hidden="true">/</span>
                    @endif
                    @if (! empty($item['url']))
                        <a href="{{ $item['url'] }}" class="transition hover:text-white">{{ $item['label'] }}</a>
                    @else
                        <span class="font-medium text-white" @if($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
