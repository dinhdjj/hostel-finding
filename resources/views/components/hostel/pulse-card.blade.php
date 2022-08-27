<div {{ $attributes->class('block group flex flex-col gap-y-2 animate-pulse') }}>

    {{-- image --}}
    <div class="aspect-[15/14]">
        <div class="h-full bg-slate-200"></div>
    </div>

    {{-- categories --}}
    <div class="flex flex-wrap gap-2">
        @foreach (range(random_int(1, 3), 1) as $i)
            <div class="{{ Arr::random(['w-10', 'w-16', 'w-24']) }} h-5 rounded-xl bg-slate-200">
            </div>
        @endforeach
    </div>

    {{-- title & address --}}
    <a class="block flex-1 space-y-1">
        <div class="{{ Arr::random(['w-28', 'w-44', 'w-72']) }} h-5 rounded bg-slate-200">
        </div>

        <div class="{{ Arr::random(['w-16', 'w-36', 'w-80']) }} h-5 rounded bg-slate-200">
        </div>
    </a>

    {{-- price & rating --}}
    <div class="flex justify-between">
        <div class="{{ Arr::random(['w-16', 'w-24', 'w-32']) }} h-5 rounded bg-slate-200">
        </div>

        <div class="{{ Arr::random(['w-12', 'w-16', 'w-20']) }} h-5 rounded bg-slate-200">
        </div>
    </div>
</div>
