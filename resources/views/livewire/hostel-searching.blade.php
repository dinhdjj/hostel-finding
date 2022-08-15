<div x-data="{
    init() {
        window.loadHostelMap($refs.map, $wire, {});
        window.placeAutocomplete($refs.search, {
            onPlaceChanged: function({
                latitude,
                longitude,
                name
            }) {
                $wire.search(latitude, longitude);
            }
        });
    }
}" class="flex h-screen flex-col">

    {{-- Header --}}
    <div class="flex h-16 justify-center border-b bg-white">

        {{-- Searching --}}
        <div class="relative mt-1 flex w-96 items-center">
            <input x-ref="search" type="text" name="search" id="search"
                class="block w-full rounded-md border-gray-300 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
    </div>

    <div class="grid flex-1 grid-cols-12 overflow-auto">

        {{-- List hostels --}}
        <div x-data id="perfect-scrollbar" class="relative col-span-5 h-full overflow-auto bg-white px-2">
            <div class="flex justify-between p-4">
                <span class="text-sm font-medium">Over 1,000 stays</span>
                <button class="flex items-center gap-1 rounded-lg border p-2 text-center">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"
                        focusable="false" style="display: block; height: 16px; width: 16px; fill: currentcolor;">
                        <path
                            d="M5 8c1.306 0 2.418.835 2.83 2H14v2H7.829A3.001 3.001 0 1 1 5 8zm0 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm6-8a3 3 0 1 1-2.829 4H2V4h6.17A3.001 3.001 0 0 1 11 2zm0 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"
                            data-selected="true" data-label-id="0" data-metatip="true"></path>
                    </svg>
                    <span class="text-sm font-medium">
                        Filters
                    </span>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-3 p-2">
                @foreach ($hostels as $hostel)
                    <x-hostels.card :hostel="$hostel" />
                @endforeach
            </div>
        </div>

        {{-- Google maps --}}
        <div x-ref="map" wire:ignore class="col-span-7"></div>
    </div>
</div>
