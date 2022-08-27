<x-guest-layout class="table h-screen w-screen overflow-hidden">
    <x-header.search class="table-cell border-b" />

    <div class="table-row h-full">
        <livewire:hostel.search :north="$north" :south="$south" :west="$west" :east="$east" />
    </div>
</x-guest-layout>
