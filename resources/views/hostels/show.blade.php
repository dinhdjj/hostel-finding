<x-guest-layout>
    <div class="px-32">
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
        <div
            class="relative my-6 grid h-96 grid-cols-1 grid-rows-1 gap-2 overflow-hidden rounded-md shadow-sm md:grid-cols-2 md:rounded-2xl">
            <div class="h-full bg-cover bg-center">
                {{ $hostel->getFirstMedia()->img()->attributes(['class' => 'h-full object-cover object-center']) }}
            </div>
            <div class="relative hidden grid-cols-2 grid-rows-2 gap-2 overflow-hidden rounded-md md:grid">
                @foreach ($hostel->getMedia() as $index => $item)
                    @if ($index > 0 && $index < 5)
                        {{ $item->img()->attributes(['class' => 'object-cover object-center']) }}
                    @endif
                @endforeach
                <div x-data="{ open: false }"
                    class="text-gray-500focus:outline-none absolute right-2 bottom-1 mb-2 mr-2 rounded-md bg-white">
                    <button x-ref="modal1_button" @click="open = true"
                        class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out">
                        <span>Show More</span>
                    </button>
                    <div x-cloak role="dialog" aria-labelledby="modal1_label" aria-modal="true" tabindex="0"
                        x-show="open" @click="open = false; $refs.modal1_button.focus()"
                        @click.away="open = false; $refs.modal1_button.focus()"
                        class="fixed top-32 left-72 flex h-3/4 w-3/5 flex-col items-center justify-center gap-2 overflow-auto">
                        <div>
                            Tất cả các ảnh
                        </div>
                        <div class="bg-white px-20 pt-10">
                            @foreach ($hostel->getMedia() as $item)
                                {{ $item->img()->attributes(['class' => 'object-cover object-center']) }}
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- info --}}
        <div class="mt-7 flex border-t-2 border-slate-500 pt-5 pb-5">
            <div class="basis-3/4">
                {{-- owner --}}
                <div>
                    <span class="font-bold">
                        Chủ nhà : {{ $hostel->owner->name }}
                    </span>
                </div>
                {{-- categories --}}
                <div class="py-5">
                    @foreach ($hostel->categories as $category)
                        <div
                            class="leading-sm inline-flex items-center rounded-full bg-blue-200 px-3 py-1 text-xs font-bold uppercase text-blue-700">
                            <x-heroicon-o-tag />
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
                                class="leading-sm inline-flex max-h-min max-w-min items-center rounded-full bg-yellow-300 px-3 py-1 text-xs font-bold uppercase text-blue-700">
                                <x-heroicon-o-tag />
                                {{ $amenity->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- price --}}
            <div>
                <div class="mb-6 h-96 w-96 rounded-lg bg-white pt-3 shadow-lg shadow-black">
                    <div class="mx-9 text-xl font-bold">
                        Giá hàng tháng : {{ number_format($hostel->monthly_price, 0, '', '.') }} vnđ
                    </div>
                    <div class="my-5 mx-9">
                        <div>
                            Một số thông tin về nhà :
                        </div>
                        <div class="">
                            <div x-data="{ length: 600, more: false }" x-init="originalContent = $el.firstElementChild.textContent.trim()">
                                <span x-text="originalContent.slice(0, length)"
                                    class="leading-5 text-gray-500">{{ $hostel->description }}</span>
                                <div>
                                    <button x-show="!more" @click="more = true"
                                        x-text="originalContent.length > length ? 'Xem thêm' : ''"
                                        class="inline-block items-center justify-center px-3 py-1 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out">
                                    </button>
                                    <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                                        x-show="more" x-cloak>
                                        <!-- Modal inner -->
                                        <div class="mx-auto max-w-3xl rounded-lg bg-white px-6 py-4 text-left shadow-lg"
                                            @click.away="more = false"
                                            x-transition:enter="motion-safe:ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100">
                                            <!-- Title / Close-->
                                            <div class="flex items-center justify-between">
                                                <h5 class="mr-3 max-w-none text-lg font-bold text-black">Description
                                                </h5>
                                            </div>
                                            <!-- content -->
                                            <div x-text="originalContent" class="w-96">
                                            </div>
                                            <button
                                                class="modal-close my-7 rounded-lg bg-indigo-500 py-3 px-4 text-white hover:bg-indigo-400"
                                                @click="more = false">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="border-t-2 border-b-2 border-slate-500 pb-20">
            @livewire('comment', ['hostel' => $hostel])
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
