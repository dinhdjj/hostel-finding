@props(['hostel'])

@php
$url = route('hostels.show', [$hostel]);
@endphp

<div
    {{ $attributes->class('block hover:-translate-y-1 transition duration-200 ease-out group flex flex-col gap-y-2') }}>

    {{-- image --}}
    <div class="aspect-[15/14]">
        {{ $hostel->getFirstMedia()->img()->attributes(['class' => 'h-full w-full rounded-xl object-cover']) }}
    </div>

    {{-- categories --}}
    <div class="flex flex-wrap gap-2">
        @foreach ($hostel->categories->take(3) as $category)
            <span class="rounded-xl bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">
                {{ $category->name }}
            </span>
        @endforeach
    </div>

    {{-- title & address --}}
    <a href="{{ $url }}" class="block flex-1">
        <div>
            <span class="text-lg font-medium text-gray-800 line-clamp-1 group-hover:text-primary-800">
                {{ $hostel->title }}
            </span>
        </div>

        <div>
            <span class="font-light text-gray-500 line-clamp-2">{{ $hostel->address }}</span>
        </div>
    </a>

    {{-- price & rating --}}
    <div class="flex">
        <div class="flex-1">
            <span class="font-bold">{{ number_format($hostel->monthly_price) }}₫</span>
            <span class="text-sm">tháng</span>
        </div>

        <div class="flex gap-2 text-gray-500 transition">
            @if ($hostel->votes_sore >= 0.05)
                <div class="flex items-center">
                    <span class="font-bold">{{ round($hostel->votes_sore * 5) }}</span>
                    <x-heroicon-s-star class="h-5 w-5" />
                </div>
            @endif

            <div class="flex items-center">
                <span class="font-bold">{{ number_format($hostel->visit_logs_count) }}</span>
                <x-heroicon-o-eye class="h-5 w-5" />
            </div>
        </div>
    </div>
</div>
