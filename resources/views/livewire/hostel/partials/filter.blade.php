<div x-data="livewire_hostel_partials_filter" wire:ignore>
    {{-- action to show --}}
    <button class="flex items-center gap-1 rounded-lg border p-2 text-center hover:shadow" @click="show = !show">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
        </svg>
        <span class="text-sm font-semibold">
            Lọc
        </span>
    </button>

    <template x-teleport="body">
        <div x-cloak x-show="show"
            class="fixed inset-0 flex flex-col items-center justify-center bg-gray-800 bg-opacity-25 p-12">
            <div x-show="show" x-transition class="h-full max-w-2xl overflow-hidden rounded-md bg-white shadow-md"
                @click.outside="show = false">

                <div class="table h-full">
                    {{-- title --}}
                    <div class="table-cell">
                        <div class="relative border-b py-4 px-6">
                            <h2 class="text-center text-xl font-semibold">Lọc</h2>

                            <div class="absolute top-3 left-3" @click="show = false">
                                <button type="button" class="rounded-full p-2 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- filters --}}
                    <div class="table-row h-full">
                        <div class="h-full space-y-8 overflow-auto p-6">
                            {{-- price --}}
                            @include('livewire.hostel.partials.filter-price')

                            {{-- categories --}}
                            <div class="space-y-2">
                                <h3 class="text-2xl font-semibold text-gray-800">Danh mục</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($categories as $category)
                                        <button class="rounded-xl px-4 py-2 text-lg"
                                            :class="{
                                                'bg-gray-100 text-gray-600': !selectedCategoryIds.includes(
                                                    @json($category->id)),
                                                'bg-primary-500 text-white': selectedCategoryIds.includes(
                                                    @json($category->id)),
                                            }"
                                            @click="onClickCategory(@json($category->id), $event)">
                                            {{ $category->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- amenities --}}
                            <div class="space-y-2">
                                <h3 class="text-2xl font-semibold text-gray-800">Tiện ích</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($amenities as $amenity)
                                        <button class="rounded-xl px-4 py-2 text-lg"
                                            :class="{
                                                'bg-gray-100 text-gray-600': !selectedAmenityIds.includes(
                                                    @json($amenity->id)),
                                                'bg-primary-500 text-white': selectedAmenityIds.includes(
                                                    @json($amenity->id)),
                                            }"
                                            @click="onClickAmenity({{ $amenity->id }}, $event)">
                                            {{ $amenity->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- actions --}}
                    <div class="table-cell">
                        <div class="flex items-center justify-between border-t py-4 px-6">
                            <button type="button" class="-translate-x-4 rounded-md px-4 py-2 hover:bg-gray-100"
                                @click="refresh">
                                <span class="text-lg font-semibold text-gray-800">Thiết lập lại</span>
                            </button>

                            <button type="button"
                                class="-translate-x-2 rounded-md bg-gray-800 px-4 py-2 hover:bg-gray-900"
                                @click="filter()">
                                <span class="text-lg font-semibold text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('livewire_hostel_partials_filter', () => ({
                show: false,
                minPrice: @json($min_price),
                maxPrice: @json($max_price),
                selectedCategoryIds: @json(array_map(fn($value) => (int) $value, $category_ids)),
                selectedAmenityIds: @json(array_map(fn($value) => (int) $value, $amenity_ids)),

                onClickCategory(cateId) {
                    if (this.selectedCategoryIds.includes(cateId)) {
                        this.selectedCategoryIds = this.selectedCategoryIds.filter(id => id != cateId);
                    } else {
                        this.selectedCategoryIds.push(cateId);
                    }
                },

                onClickAmenity(amenityId) {
                    if (this.selectedAmenityIds.includes(amenityId)) {
                        this.selectedAmenityIds = this.selectedAmenityIds.filter(id => id != amenityId);
                    } else {
                        this.selectedAmenityIds.push(amenityId);
                    }
                },

                refresh() {
                    this.minPrice = null;
                    this.maxPrice = null;
                    this.selectedCategoryIds = [];
                    this.selectedAmenityIds = [];
                },

                filter() {
                    @this.filter(
                        [this.minPrice, this.maxPrice],
                        this.selectedCategoryIds,
                        this.selectedAmenityIds
                    );

                    this.show = false;
                },
            }));
        });
    </script>
@endpush
