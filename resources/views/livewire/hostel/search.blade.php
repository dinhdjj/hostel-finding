<div x-data="livewire_hostel_search" class="flex h-full flex-1 flex-col-reverse overflow-auto md:grid md:grid-cols-12">

    {{-- hostels --}}
    <div class="bg-white px-2 md:col-span-5 md:overflow-auto">
        <div @class(['hidden' => $hostels->total() === 0])>
            <div class="flex justify-between p-4">
                @if ($hostels->total() < 1000)
                    <span wire:loading.remove class="font-bold text-gray-800"> {{ $hostels->total() }}
                        nhà trọ ở khu vực này
                    </span>
                    <div wire:loading.block class="h-5 w-40 rounded-xl bg-slate-200">
                    </div>
                @else
                    <span wire:loading.remove class="font-bold text-gray-800">
                        Hơn 1,000 nhà trọ ở khu vực này
                    </span>
                    <div wire:loading.block class="h-5 w-40 rounded-xl bg-slate-200">
                    </div>
                @endif
                @include('livewire.hostel.partials.filter')
            </div>

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 p-2 lg:grid-cols-2">
                @foreach ($hostels as $hostel)
                    <x-hostel.card :hostel="$hostel" wire:loading.remove
                        @mouseover="mouseoverHostelCard({{ $hostel->id }}, $event)"
                        @mouseout="mouseoutHostelCard({{ $hostel->id }}, $event)" />
                    <div wire:loading.block>
                        <x-hostel.pulse-card />
                    </div>
                @endforeach
            </div>

            <div class="py-6">
                {{ $hostels->links('paginations.centered-simple', ['livewire' => true]) }}
            </div>
        </div>
        <div @class(['py-12 px-6', 'hidden' => $hostels->total() !== 0])>
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
                <button wire:click="showNearestHostels"
                    class="mt-6 rounded-lg border-2 px-3 py-3 shadow transition ease-in-out active:translate-y-1">
                    <span class="text-sm font-bold">Tìm nhà trọ gần nhất</span>
                </button>
            </div>
            <div wire:loading.block class="mt-6 h-[52px] w-[165px] rounded-xl bg-slate-200">
            </div>
        </div>
    </div>

    {{-- maps --}}
    <div class="relative h-96 w-full md:col-span-7 md:h-auto md:w-auto">
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
                north: @entangle('north'),
                south: @entangle('south'),
                west: @entangle('west'),
                east: @entangle('east'),
                notReactOnNextBoundsChange: false,
                async init() {
                    this.google = await window.useGoogleMaps();

                    this.map = new this.google.maps.Map(this.$refs.map, {
                        zoom: 14,
                        minZoom: 7,
                        maxZoom: 19,
                    });

                    this.updateMarkersOnMap();
                    this.$watch('hostels', () => {
                        this.updateMarkersOnMap();
                    });

                    this.fitBoundsInMap();
                    this.$wire.on('update-bounds', () => {
                        this.fitBoundsInMap();
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

                    this.map.addListener('bounds_changed', () => {
                        if (this.notReactOnNextBoundsChange) {
                            this.notReactOnNextBoundsChange = false;
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
                                    <a href="{{ url('') }}/hostels/${hostel.slug}" target="_blank" id="hostel-on-map-${hostel.id}" class="rounded-full border bg-white py-1 px-2 font-extrabold text-gray-800 shadow text-sm hover:bg-gray-900 hover:text-white">
                                        ${this.formatNumber(hostel.monthly_price)}₫
                                    </a>
                                </div>
                            `,
                        });

                        this.markers.push(marker);
                    })
                },
                fitBoundsInMap() {
                    const bounds = new this.google.maps.LatLngBounds(
                        new this.google.maps.LatLng(this.south, this.west),
                        new this.google.maps.LatLng(this.north, this.east),
                    );

                    this.notReactOnNextBoundsChange = true;
                    this.map.fitBounds(bounds);
                },
                mouseoverHostelCard(id, e) {
                    const el = document.getElementById(`hostel-on-map-${id}`);
                    if (!el) return;

                    el.classList.add('!bg-gray-900');
                    el.classList.add('!text-white');
                },
                mouseoutHostelCard(id, e) {
                    const el = document.getElementById(`hostel-on-map-${id}`);
                    if (!el) return;

                    el.classList.remove('!bg-gray-900');
                    el.classList.remove('!text-white');
                },
                formatNumber(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
            }))
        })
    </script>
</div>
