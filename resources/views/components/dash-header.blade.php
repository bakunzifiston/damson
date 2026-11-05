@props(['title', 'subtitle' => null, 'crumbs' => []])

{{-- Page heading for staff dashboard pages. $crumbs: [['label' => 'Orders', 'url' => '...'], ['label' => 'Current']] --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div class="min-w-0">
        @if (count($crumbs))
            <nav aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-1.5 text-sm text-stone-500">
                    <li><a href="{{ route('data-hub.index') }}" class="transition hover:text-brand-900">Dashboard</a></li>
                    @foreach ($crumbs as $crumb)
                        <li class="flex items-center gap-1.5">
                            <span class="text-stone-300" aria-hidden="true">/</span>
                            @if (! empty($crumb['url']))
                                <a href="{{ $crumb['url'] }}" class="transition hover:text-brand-900">{{ $crumb['label'] }}</a>
                            @else
                                <span class="text-stone-700" aria-current="page">{{ $crumb['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1 class="dash-title {{ count($crumbs) ? 'mt-2' : '' }}">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-1.5 max-w-2xl text-sm text-stone-600">{{ $subtitle }}</p>@endif
    </div>
    @if (isset($actions) && ! $actions->isEmpty())
        <div class="flex shrink-0 flex-wrap items-center gap-2">{{ $actions }}</div>
    @endif
</div>
