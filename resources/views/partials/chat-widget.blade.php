@if (config('damson.live_chat.enabled'))
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <details class="group flex flex-col items-end">
            <summary class="list-none [&::-webkit-details-marker]:hidden">
                <span class="sr-only">Open support options</span>
                <span class="flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-brand-900 text-white shadow-md ring-2 ring-damson-orange/30 hover:bg-brand-950">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </span>
            </summary>
            <div class="mb-3 w-[min(100vw-2rem,22rem)] rounded-lg border border-brand-900/12 bg-damson-panel p-4 shadow-lg">
                <p class="text-sm font-medium text-stone-900">Support</p>
                <p class="mt-2 text-sm text-stone-600 leading-relaxed">
                    For urgent questions, use the contact form or reach us during <strong>{{ config('damson.live_chat.hours') }}</strong>.
                    You can later connect WhatsApp Business, Intercom, or Tawk.to for full live chat.
                </p>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('contact') }}" class="damson-btn w-full justify-center">Contact</a>
                    @if (config('damson.live_chat.whatsapp'))
                        <a href="{{ config('damson.live_chat.whatsapp') }}" class="rounded-xl border border-brand-900/12 px-4 py-2 text-center text-sm font-medium text-stone-800 hover:bg-brand-100/50 transition" rel="noopener noreferrer" target="_blank">Open WhatsApp</a>
                    @endif
                </div>
            </div>
        </details>
    </div>
@endif
