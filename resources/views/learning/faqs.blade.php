@extends('layouts.site')

@section('title', 'FAQs')

@section('content')
    <x-simple-hero title="FAQs" subtitle="Quick answers about farming and our products.">
        @if ($categories->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2" role="group" aria-label="Filter by category">
                @foreach ($categories->prepend(null) as $cat)
                    @php $active = ($category ?: null) === $cat; @endphp
                    <a href="{{ $cat === null ? route('learning.faqs') : route('learning.faqs', ['category' => $cat]) }}" @if ($active) aria-current="true" @endif
                       class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition {{ $active ? 'border-brand-900 bg-brand-900 text-white' : 'border-stone-300 bg-white text-stone-700 hover:border-brand-900' }}">{{ $cat ?? 'All' }}</a>
                @endforeach
            </div>
        @endif
    </x-simple-hero>
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-12">
        <div class="space-y-3">
            @forelse ($faqs as $faq)
                <details class="faq-details group rounded-xl border border-stone-200 bg-white px-5 py-4 shadow-sm">
                    <summary class="text-[15px]">
                        {{ $faq->question }}
                        <span class="shrink-0 text-xl leading-none text-stone-400 transition group-open:rotate-45" aria-hidden="true">+</span>
                    </summary>
                    <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $faq->answer }}</div>
                </details>
            @empty
                <p class="rounded-xl border border-dashed border-stone-300 py-12 text-center text-sm text-stone-500">No FAQs found.</p>
            @endforelse
        </div>
        <p class="mt-10 text-center text-sm text-stone-600">Can't find your answer? <a href="{{ route('contact') }}" class="font-medium text-brand-700 underline underline-offset-4 hover:text-damson-orange">Contact us</a>.</p>
    </div>
@endsection
