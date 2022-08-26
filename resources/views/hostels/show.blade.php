<x-guest-layout>
    <div class="container mx-auto px-4">
        <div>
            Header
            <hr>
        </div>
        {{-- Title --}}
        <div class="flex-col items-center border-b-2 border-slate-500">
            <div>
                <h1 class="text-9xl font-bold">{{ $hostel->title }}</h1>
            </div>
            <div class="flex items-center pb-5">
                <div class="flex items-center font-bold">
                    {{ round($hostel->votes_avg_score * 5, 2) }}
                    <x-heroicon-s-star class="inline-block h-4" />
                    <x-bi-dot />
                    {{ $hostel->votes_count }} reviews
                </div>

                <div class="pl-9">
                    <div class="text-sm leading-5 text-gray-500">
                        <a href="#">{{ $hostel->address }}</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- media --}}
        <x-hostel.image-section :hostel="$hostel" class="my-6" />
        {{-- info --}}
        <x-hostel.info-section :hostel="$hostel" class="my-6" />

        {{-- comments --}}
        <div class="border-t-2 border-b-2 border-slate-500 pb-20">
            <livewire:comment :hostel="$hostel" />
        </div>

        {{-- map --}}
        <div x-data="dropdown" class="my-10 px-20">
            <div class="my-5 text-2xl font-bold">
                Nơi bạn sẽ đến
            </div>
            <div x-ref="map" class="h-96 w-full"></div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                google: null,
                map: null,
                latitude: @json($hostel->latitude),
                longitude: @json($hostel->longitude),
                title: @json($hostel->title),
                async init() {
                    this.google = await window.useGoogleMaps();

                    this.map = new this.google.maps.Map(this.$refs.map, {
                        center: {
                            lat: this.latitude,
                            lng: this.longitude
                        },
                        zoom: 14,
                        maxZoom: 19,
                        minZoom: 7,
                    });
                    const marker = window.createHtmlMapMarker(this.google, {
                        position: new google.maps.LatLng(
                            this.latitude,
                            this.longitude
                        ),
                        map: this.map,
                        html: /*html*/ `
                        <div class="p-2 rounded-full bg-red-200">
                            <div class="p-3 rounded-full bg-red-500 flex items-center justify-center">
                                <svg class="text-white"  viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; height: 22px; width: 22px; fill: currentcolor;">
                                    <path d="M8.602 1.147l.093.08 7.153 6.914-.696.718L14 7.745V14.5a.5.5 0 0 1-.41.492L13.5 15H10V9.5a.5.5 0 0 0-.41-.492L9.5 9h-3a.5.5 0 0 0-.492.41L6 9.5V15H2.5a.5.5 0 0 1-.492-.41L2 14.5V7.745L.847 8.86l-.696-.718 7.153-6.915a1 1 0 0 1 1.297-.08z"></path>
                                </svg>
                            </div>
                        </div>
                `,
                    });

                }
            }))
        })

        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('dropdown', () => ({
        //         open: false,

        //         toggle() {
        //             this.open = !this.open
        //         },
        //     }))
        // })
    </script>
</x-guest-layout>
