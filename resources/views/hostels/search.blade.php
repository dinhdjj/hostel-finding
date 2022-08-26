<x-guest-layout class="table h-screen w-screen overflow-hidden">
    <x-header.search class="table-cell border-b" />

    <div class="table-row h-full">
        <livewire:hostel.search :latitude="$latitude" :longitude="$longitude">
    </div>
</x-guest-layout>
