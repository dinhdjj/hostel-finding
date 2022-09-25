<x-guest-layout>
    <x-slot name="head">
        <title>{{ $hostel->title }}</title>

        <x-social-meta :title="$hostel->title" :description="$hostel->address" :image="$hostel->getFirstMediaUrl()" />
    </x-slot>

    <x-header.search class="mb-4 border-b" />

    <div class="container mx-auto max-w-5xl px-4">
        {{-- Title --}}
        <h1 class="text-3xl font-bold text-gray-700 md:text-4xl xl:text-6xl">{{ $hostel->title }}</h1>

        {{-- Overview --}}
        <div class="mt-1 flex flex-wrap items-center gap-2">
            <div class="flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1.5 font-semibold text-gray-500">
                {{ round($hostel->votes_avg_score * 5, 2) }}
                <x-heroicon-s-star class="inline-block h-4 text-yellow-500" />
            </div>
            <div class="flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1.5 font-semibold text-gray-500">
                {{ $hostel->votes_count }} đánh giá
            </div>
            <div class="flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1.5 font-semibold text-gray-500">
                {{ $hostel->visit_logs_count }} lượt xem
            </div>
        </div>

        {{-- Address --}}
        <div class="mt-2 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </svg>
            <a href="https://www.google.com/maps/place/ {{ $hostel->address }}"
                class="text-sm font-thin text-gray-600 underline hover:text-primary-600" target="_blank">
                {{ $hostel->address }}
            </a>
        </div>

        {{-- media --}}
        <x-hostel.image-section :hostel="$hostel" class="my-6" />
        {{-- info --}}

        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-3 space-y-2 lg:col-span-2">
                {{-- categories --}}
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($hostel->categories as $category)
                        <div class="rounded-xl bg-gray-100 px-4 py-2 text-lg text-gray-600">
                            {{ $category->name }}
                        </div>
                    @endforeach
                </div>

                {{-- amenities --}}
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($hostel->amenities as $amenity)
                        <div class="rounded-xl bg-gray-100 px-4 py-2 text-lg text-gray-600">
                            {{ $amenity->name }}
                        </div>
                    @endforeach
                </div>

                {{-- Description --}}
                <div class="px-2">
                    <x-markdown class="prose !max-w-full lg:prose-xl">
                        {!! $hostel->description !!}
                    </x-markdown>
                </div>
            </div>

            {{-- infos & actions --}}
            <div class="col-span-3 space-y-4 rounded-md px-4 py-4 shadow lg:col-span-1">
                <livewire:hostel.subscribe-for-news :hostel="$hostel" />

                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        <div>
                            <span class="font-bold">{{ number_format($hostel->monthly_price) }}₫</span>
                            <span class="text-sm">tháng</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3" />
                        </svg>

                        <div>
                            <span class="font-bold">{{ number_format($hostel->size, 1) }}</span>
                            <span class="text-sm">m2</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        <div>
                            {{-- TODO: replace with actual value --}}
                            <span class="font-bold">{{ 3 }}</span>
                            <span class="text-sm">người ở</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-4 space-y-2 rounded-md px-4 py-6 shadow">
            <h2 id="notes-title" class="mb-4 text-lg font-medium text-gray-800">Bình luận</h2>
            <div>
                <livewire:hostel.comments :hostel="$hostel" />
            </div>
        </div>

        {{-- map --}}
        <div x-data="dropdown" class="mt-8 space-y-2">
            <h2 id="notes-title" class="text-lg font-medium text-gray-800">Nơi bạn sẽ đến</h2>
            <div class="mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <a href="https://www.google.com/maps/place/ {{ $hostel->address }}"
                    class="text-sm font-thin text-gray-600 underline hover:text-primary-600" target="_blank">
                    {{ $hostel->address }}
                </a>
            </div>
            <div x-ref="map" class="h-96 w-full"></div>
        </div>

        {{-- Owner --}}
        <div class="mt-8 rounded-md bg-white p-6 shadow">
            <div class="mb-4 flex justify-between">
                <div class="flex items-center">
                    <img class="mr-4 h-20 w-20 rounded-full border border-indigo-50 p-1"
                        src="{{ $hostel->owner->profile_photo_url }}" alt="avatar">
                    <div>
                        <div class="mb-2 flex gap-2">
                            <h3 class="font-medium">{{ $hostel->owner->name }}</h3>
                            <div class="rounded bg-blue-50 py-1 px-2 text-xs text-blue-500">
                                {{ $hostel->owner->describe()['hostels_count'] }} nhà
                            </div>
                            <div class="flex items-center gap-1 rounded bg-blue-50 py-1 px-2 text-xs text-blue-500">
                                {{ round($hostel->owner->describe()['hostel_votes_score_avg'], 1) }}
                                <x-heroicon-s-star class="inline-block h-4 text-yellow-500" />
                            </div>
                            <div class="rounded bg-blue-50 py-1 px-2 text-xs text-blue-500">
                                {{ round($hostel->owner->describe()['hostel_votes_count'], 1) }}
                                đánh giá
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">
                            <span>Chủ nhà</span>
                            <span>-</span>
                            <span>Tham gia {{ $hostel->owner->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                </div>
                <button class="mt-6 self-start focus:outline-none">
                    <svg class="h-3 w-3 text-gray-200" viewBox="0 0 12 4" fill="none"
                        xmlns="http://www.w3.org/2000/svg" data-config-id="auto-svg-1-4">
                        <path
                            d="M6 0.666687C5.26667 0.666687 4.66667 1.26669 4.66667 2.00002C4.66667 2.73335 5.26667 3.33335 6 3.33335C6.73333 3.33335 7.33333 2.73335 7.33333 2.00002C7.33333 1.26669 6.73333 0.666687 6 0.666687ZM1.33333 0.666687C0.6 0.666687 0 1.26669 0 2.00002C0 2.73335 0.6 3.33335 1.33333 3.33335C2.06667 3.33335 2.66667 2.73335 2.66667 2.00002C2.66667 1.26669 2.06667 0.666687 1.33333 0.666687ZM10.6667 0.666687C9.93333 0.666687 9.33333 1.26669 9.33333 2.00002C9.33333 2.73335 9.93333 3.33335 10.6667 3.33335C11.4 3.33335 12 2.73335 12 2.00002C12 1.26669 11.4 0.666687 10.6667 0.666687Z"
                            fill="currentColor"></path>
                    </svg>
                </button>
            </div>

            <div class="-mx-2 flex flex-wrap">
                <div class="mb-2 w-full px-2 md:mb-0">
                    <button
                        class="flex w-full items-center justify-center gap-2 rounded bg-indigo-500 py-2 text-sm text-white transition duration-200 hover:bg-indigo-600"
                        onclick="navigator.clipboard.writeText('{{ $hostel->owner->phone_number }}');">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        <span data-config-id="primary-action1">{{ $hostel->owner->phone_number }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-footer.simple class="mt-12" />
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
