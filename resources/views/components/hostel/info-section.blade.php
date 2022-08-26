@props(['hostel'])

<div {{ $attributes->class('border-t-2 border-slate-500 pt-5 pb-5 space-y-4') }}>

    {{-- owner --}}
    <div>
        <span class="font-bold">
            Chủ nhà : {{ $hostel->owner->name }}
        </span>
    </div>

    {{-- categories --}}
    <div class="flex flex-wrap gap-2">
        @foreach ($hostel->categories as $category)
            <div
                class="flex items-center gap-1 rounded-full bg-primary-200 px-3 py-1 text-xs font-bold uppercase text-primary-700">
                <x-heroicon-o-tag class="h-5 w-5" />
                {{ $category->name }}
            </div>
        @endforeach
    </div>

    {{-- amenities --}}
    <div>
        <div>
            Nơi này có những gì cho bạn
        </div>
        <div class="">
            @foreach ($hostel->amenities as $amenity)
                <div
                    class="leading-sm inline-flex max-h-min max-w-min items-center rounded-full bg-yellow-300 px-3 py-1 text-xs font-bold uppercase text-primary-700">
                    <x-heroicon-o-tag />
                    {{ $amenity->name }}
                </div>
            @endforeach
        </div>
    </div>

    {{-- price & size --}}
    <div class="space-y-1">
        <div>
            <span> Giá: </span>
            <span>
                <span class="font-bold">{{ number_format($hostel->monthly_price) }}</span>
                ₫
            </span>
        </div>

        <div>
            <span> Diện tích: </span>
            <span>
                <span class="font-bold">{{ number_format($hostel->size, 1) }}</span>
                m2
            </span>
        </div>
    </div>

    {{-- description --}}
    <div>
        <x-markdown class="prose !max-w-full lg:prose-xl">
            {!! $hostel->description !!}
        </x-markdown>
    </div>
</div>
