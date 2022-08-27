<div x-data="livewire_hostel_search" class="grid h-full flex-1 grid-cols-12 overflow-auto">

    {{-- hostels --}}
    <div class="relative col-span-5 overflow-auto bg-white px-2">
        @if ($hostels->total() > 0)
            <div class="flex justify-between p-4">
                @if ($hostels->total() < 1000)
                    <span wire:loading.remove class="font-bold text-gray-800"> {{ $hostels->total() }} nhà trọ gần đây
                    </span>
                    <div wire:loading.block class="h-5 w-36 rounded-xl bg-slate-200">
                    </div>
                @else
                    <span wire:loading.remove class="font-bold text-gray-800"> Hơn 1,000 nhà trọ gần đây </span>
                    <div wire:loading.block class="h-5 w-36 rounded-xl bg-slate-200">
                    </div>
                @endif
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

            <div class="grid grid-cols-2 gap-y-6 gap-x-4 p-2">
                @foreach ($hostels as $hostel)
                    <x-hostel.card :hostel="$hostel" wire:loading.remove />
                    <div wire:loading.block>
                        <x-hostel.pulse-card />
                    </div>
                @endforeach
            </div>

            <div class="py-6">
                {{ $hostels->links('paginations.centered-simple', ['livewire' => true]) }}
            </div>
        @else
            <div class="py-12 px-6">
                <h2 wire:loading.remove class="text-2xl font-bold text-gray-800">
                    Không tìm thầy nhà trọ ở khu vực này
                </h2>
                <div wire:loading.block class="h-8 w-80 rounded-xl bg-slate-200">
                </div>

                <p wire:loading.remove class="mt-3 text-gray-600">
                    Bạn hãy thử tìm ở một khu vực rộng hơn, hoặc một khu
                    vực khác.
                </p>
                <div wire:loading.block class="mt-3 h-5 w-96 rounded-xl bg-slate-200">
                </div>

                <div wire:loading.remove>
                    <button wire:click="showNearestHostels" class="mt-6 rounded-lg border-2 px-3 py-3 shadow">
                        <span class="text-sm font-bold">Hiển thị nhà trọ gần nhất</span>
                    </button>
                </div>
                <div wire:loading.block class="mt-6 h-[52px] w-[191px] rounded-xl bg-slate-200">
                </div>
            </div>
        @endif
    </div>

    {{-- maps --}}
    <div class="relative col-span-7">
        <div x-ref="map" wire:ignore class="h-full"></div>

        <div wire:loading
            class="absolute top-[50%] left-[50%] -translate-x-[50%] -translate-y-[50%] rounded-full bg-white p-2 shadow">
            <svg class="h-8 w-8 animate-spin text-gray-600" viewBox="0 0 48 48" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                <path d="M4 24C4 35.0457 12.9543 44 24 44V44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M36 24C36 17.3726 30.6274 12 24 12C17.3726 12 12 17.3726 12 24C12 30.6274 17.3726 36 24 36V36"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('livewire_hostel_search', () => ({
                google: null,
                map: null,
                markers: [],
                hostels: @entangle('hostelsData'),
                async init() {
                    const south = @json($south);
                    const north = @json($north);
                    const west = @json($west);
                    const east = @json($east);
                    this.google = await window.useGoogleMaps();
                    const bounds = new this.google.maps.LatLngBounds(
                        new this.google.maps.LatLng(south, west),
                        new this.google.maps.LatLng(north, east),
                    );

                    this.map = new this.google.maps.Map(this.$refs.map, {
                        zoom: 14,
                        minZoom: 7,
                        maxZoom: 19,
                    });

                    this.map.fitBounds(bounds);

                    this.updateMarkersOnMap();
                    this.$watch('hostels', () => {
                        this.updateMarkersOnMap();
                    });

                    this.listenOnBoundsChange();
                },
                listenOnBoundsChange() {
                    const onBoundsChange = _.debounce(async () => {
                        const bounds = this.map.getBounds();
                        const north = bounds.getNorthEast().lat();
                        const east = bounds.getNorthEast().lng();
                        const south = bounds.getSouthWest().lat();
                        const west = bounds.getSouthWest().lng();
                        this.$wire.updateBounds(north, south, west, east);
                    }, 1000);

                    let firstly = true;
                    this.map.addListener('bounds_changed', () => {
                        if (firstly) {
                            firstly = false;
                            return;
                        }

                        onBoundsChange();
                    });
                },
                updateMarkersOnMap() {
                    const hostels = this.$wire.hostelsData;

                    this.markers.forEach((marker) => marker.setMap(null));
                    this.markers = [];
                    hostels.forEach((hostel) => {
                        const marker = createHtmlMapMarker(this.google, {
                            position: new this.google.maps.LatLng(
                                hostel.latitude,
                                hostel.longitude
                            ),
                            map: this.map,
                            html: /*html*/ `
                                <div class="relative">
                                    <button class="rounded-full border bg-white py-1 px-2 font-extrabold text-gray-800 shadow text-sm">
                                        ${this.formatNumber(hostel.monthly_price)}₫
                                    </button>
                                    <div is-popup class="hidden absolute bottom-0 right-0">
                                        xin chao ${hostel.title}
                                    </div>
                                </div>
                            `,
                        });

                        marker.addListener('click', (e) => {
                            const popup =
                                e.target.parentElement.querySelector('[is-popup]');
                            popup.classList.toggle('hidden');
                        });

                        this.markers.push(marker);
                    })
                },
                formatNumber(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
            }))
        })
    </script>
</div>
