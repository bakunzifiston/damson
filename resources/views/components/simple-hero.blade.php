@props(['title', 'subtitle' => null, 'back' => null, 'backLabel' => 'Learning'])

<section class="border-b border-stone-200 bg-brand-50/60">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
        <nav aria-label="Breadcrumb" class="text-sm text-stone-500">
            <a href="{{ route('learning.index') }}" class="transition hover:text-brand-900">Learning</a>
            <span class="mx-1.5 text-stone-300" aria-hidden="true">/</span>
            <span class="text-stone-700" aria-current="page">{{ $title }}</span>
        </nav>
        <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-brand-950 sm:text-4xl">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-3 max-w-2xl text-stone-600">{{ $subtitle }}</p>@endif
        {{ $slot }}
    </div>
</section>
