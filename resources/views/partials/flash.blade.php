@if ($errors->any())
    <div class="border-b border-red-100 bg-red-50 px-4 py-3 text-center text-sm text-red-800" role="alert">
        <ul class="mx-auto max-w-xl list-inside list-disc text-left">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
    <div class="border-b border-brand-900/10 bg-damson-orange-muted px-4 py-2.5 text-center text-sm font-medium text-brand-950" role="status">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="border-b border-red-100 bg-red-50 px-4 py-2.5 text-center text-sm text-red-800" role="alert">
        {{ session('error') }}
    </div>
@endif
