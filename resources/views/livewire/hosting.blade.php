<form wire:submit.prevent="createHostel" class="space-y-8 divide-y divide-gray-200 py-6 px-20">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div>
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Đăng nhà trọ</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Chào mừng {{ Auth::user()->name }} trở lại</p>
            </div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Tiêu đề
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input wire:model.defer='title' type="text" name="title" id="title" required
                                max="255"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div wire:ignore
                    class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Mô tả
                    </label>
                    <div wire:model.defer='description' class="mt-1 sm:col-span-2 sm:mt-0">
                        <x-easy-mde name="about">
                        </x-easy-mde>
                    </div>
                </div>
                <div x-data="dropdown"
                    class="m:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <div class="my-5 text-2xl font-bold">
                        Phòng trọ của bạn ở đâu
                    </div>
                    <div class="gap-10 sm:flex">
                        <button type="button" x-ref="button"
                            class="mb-5 rounded border-b-4 border-blue-700 bg-blue-500 py-2 px-4 font-bold text-white hover:border-blue-500 hover:bg-blue-400">Địa
                            chỉ hiện tại</button>
                        <div>
                            <input type="text" x-ref="address" @keydown.enter.prevent=""
                                class="mb-5 w-96 rounded-md border border-gray-300 px-4 py-2" placeholder="Tìm kiếm">
                        </div>
                    </div>
                    <div x-ref="map" wire:ignore class="h-96 w-full"></div>
                    <div class="flex">
                        <span
                            class="inline-flex items-center border border-r-0 border-gray-300 bg-gray-200 px-3 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400">
                            Địa chỉ
                        </span>
                        <input type="text" wire:model="address" disabled
                            class="block w-full min-w-0 flex-1 border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="...">
                    </div>
                </div>
                <div class="sm:border-t sm:border-gray-200">
                    {{ $this->form }}
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Kích thước
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input required type="number" wire:model.defer='size' name="size" min="1"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Số người tối
                        đa
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input required type="number" wire:model.defer='allowable_number_of_people'
                                name="allowable_number_of_people" min="1"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Giá
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input required type="number" wire:model.defer='price' name="price" min="1"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-y-6 divide-y divide-gray-200 pt-8 sm:space-y-5 sm:pt-10">
        <div class="gap-10 space-y-6 divide-y divide-gray-200 sm:grid sm:grid-cols-2 sm:space-y-5">
            <div class="pt-6 sm:pt-5">
                <div role="group" aria-labelledby="label-email">
                    <div
                        class="border-t-2 sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4 sm:border-gray-200 sm:pt-5">
                        <div>
                            <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                id="label-email">
                                Các danh mục</div>
                        </div>
                        <div class="mt-4 sm:col-span-2 sm:mt-0">
                            <div wire:ignore class="max-w-lg space-y-4">
                                @foreach ($categories as $category)
                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="comments" name="comments" type="checkbox"
                                                value="{{ $category->id }}"
                                                wire:model.defer='categoriesList.{{ $category->id }}'
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="comments"
                                                class="font-medium text-gray-700">{{ $category->name }}</label>
                                            <p class="text-gray-500">{{ $category->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div role="group" aria-labelledby="label-notifications">
                    <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4 sm:pt-5">
                        <div>
                            <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                id="label-notifications">Các tiện nghi</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="max-w-lg">
                                <div class="space-y-4">
                                    @foreach ($amenities as $amenity)
                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input id="comments" name="comments" type="checkbox"
                                                    value="{{ $amenity->id }}"
                                                    wire:model.defer='amenitiesList.{{ $amenity->id }}'
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments"
                                                    class="font-medium text-gray-700">{{ $amenity->name }}</label>
                                                <p class="text-gray-500">{{ $amenity->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="button" wire:click="backToHome"
                class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Hủy bỏ
            </button>
            <button wire:loading.attr='disabled' type="submit"
                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-gray-500">
                <x-uiw-loading wire:loading class="h-5 w-5 animate-spin" />
                Tạo mới
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            google: null,
            map: null,
            address: null,
            center: {
                lat: 10.77,
                lng: 106.69
            },
            async init() {
                this.google = await window.useGoogleMaps();
                this.map = new this.google.maps.Map(this.$refs.map, {
                    center: this.center,
                    zoom: 14,
                    maxZoom: 19,
                    minZoom: 7,
                });
                marker = new this.google.maps.Marker({
                    position: this.center,
                    map: this.map,
                    draggable: true,
                    animation: this.google.maps.Animation.DROP,
                });
                const defaultBounds = {
                    north: this.center.lat + 0.1,
                    south: this.center.lat - 0.1,
                    east: this.center.lng + 0.1,
                    west: this.center.lng - 0.1,
                };
                const input = this.$refs.address;
                const options = {
                    bounds: defaultBounds,
                    componentRestrictions: {
                        country: "vn"
                    },
                    fields: ["address_components", "geometry", "icon", "name"],
                    strictBounds: false,
                };
                // search Box
                const searchBox = new google.maps.places.SearchBox(input);
                searchBox.addListener('places_changed', () => {
                    const places = searchBox.getPlaces();
                    if (places.length == 0) {
                        return;
                    }
                    const bounds = new this.google.maps.LatLngBounds();
                    places.forEach(place => {
                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    this.map.fitBounds(bounds);
                    this.center = bounds.getCenter();
                    marker.setPosition(this.center);
                    const geocoder = new this.google.maps.Geocoder();
                    geocoder.geocode({
                        location: this.center
                    }, (results, status) => {
                        if (status === 'OK') {
                            if (results[0]) {
                                this.address = results[0].formatted_address;
                                this.$wire.address = this.address;
                                this.$wire.setLatLng(this.center.toJSON());
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                });
                //auto complete
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener("place_changed", () => {
                    const places = autocomplete.getPlace();
                    if (places.geometry) {
                        this.center = {
                            lat: places.geometry.location.lat(),
                            lng: places.geometry.location.lng(),
                        };
                        this.map.setCenter(this.center);
                    }
                    marker.setPosition(this.center);
                    const geocoder = new this.google.maps.Geocoder();
                    geocoder.geocode({
                        location: this.center
                    }, (results, status) => {
                        if (status === 'OK') {
                            if (results[0]) {
                                this.address = results[0].formatted_address;
                                this.$wire.address = this.address;
                                this.$wire.setLatLng(this.center.toJSON());
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                });
                //get current location
                this.$refs.button.addEventListener('click', () => {
                    navigator.geolocation.getCurrentPosition(position => {
                        this.center = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        this.map.setCenter(this.center);
                        const geocoder = new this.google.maps.Geocoder();
                        geocoder.geocode({
                            location: this.center
                        }, (results, status) => {
                            if (status === 'OK') {
                                if (results[0]) {
                                    this.address = results[0]
                                        .formatted_address;
                                    this.$wire.address = this.address;
                                    this.$wire.setLatLng(this.center
                                        .toJSON());
                                } else {
                                    window.alert('No results found');
                                }
                            } else {
                                window.alert(
                                    'Geocoder failed due to: ' +
                                    status);
                            }
                        });
                        marker.setMap(null);
                        marker = new this.google.maps.Marker({
                            position: this.center,
                            map: this.map,
                            draggable: true,
                            animation: this.google.maps.Animation.DROP,
                        });
                    });

                });

                this.map.addListener('center_changed', () => {
                    this.center = this.map.getCenter();
                    marker.setPosition(this.center);

                });
                // drag end
                this.map.addListener('dragend', () => {
                    const geocoder = new this.google.maps.Geocoder();
                    geocoder.geocode({
                        location: this.center
                    }, (results, status) => {
                        if (status === 'OK') {
                            if (results[0]) {
                                this.address = results[0].formatted_address;
                                this.$wire.address = this.address;
                                this.$wire.setLatLng(this.center.toJSON());
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                });
            }
        }))
    })
</script>
