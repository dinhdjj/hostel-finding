<div x-data="livewire_hostel_partials_filter_price" class="space-y-2">
    <h3 class="text-2xl font-semibold text-gray-800">Giá hàng tháng</h3>

    <div class="flex items-center justify-between gap-3">
        <div class="flex-1">
            <input x-ref="minPrice" x-mask:dynamic="'₫' + $money($input)" type="text" @input="onInputMinPrice"
                @blur="onBlurMinPrice" class="w-full rounded border border-gray-200 text-center">
        </div>

        <span> – </span>

        <div class="flex-1">
            <input x-ref="maxPrice" x-mask:dynamic="'₫' + $money($input)" type="text" @input="onInputMaxPrice"
                @blur="onBlurMaxPrice" class="w-full rounded border border-gray-200 text-center">
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('livewire_hostel_partials_filter_price', () => ({
                min: @json($smallestPrice),
                max: @json($largestPrice),
                requiredDistance: 1000000,

                init() {
                    this.setLocalMinPrice(this.minPrice ?? this.min)
                    this.$watch('minPrice', (value) => {
                        if (value === null) {
                            this.setLocalMinPrice(this.min);
                        }
                    });

                    this.setLocalMaxPrice(this.maxPrice ?? this.max)
                    this.$watch('maxPrice', (value) => {
                        if (value === null) {
                            this.setLocalMaxPrice(this.max);
                        }
                    });
                },

                /* min price */
                get localMinPrice() {
                    let minPrice = this
                        .$refs
                        .minPrice
                        .value
                        .match(/[\d,]+/g)?.[0]?.replaceAll(',', '');
                    if (!minPrice) return;
                    return parseInt(minPrice);
                },
                setLocalMinPrice(value) {
                    this.$refs.minPrice.value = value;
                    this.dispatchInputEvent(this.$refs.minPrice);
                    this.setGlobalMinPrice(value);
                },
                setGlobalMinPrice(value) {
                    if (value == this.min) {
                        this.minPrice = null;
                        return;
                    }
                    this.minPrice = value;
                },
                onInputMinPrice(e) {
                    const minPrice = this.localMinPrice;
                    if (minPrice) this.setGlobalMinPrice(minPrice);
                },
                onBlurMinPrice(e) {
                    let minPrice = this.localMinPrice;
                    minPrice ??= 0;

                    if (minPrice < this.min) {
                        this.setLocalMinPrice(this.min);
                    }

                    if (minPrice + this.requiredDistance > this.localMaxPrice) {
                        this.setLocalMinPrice(this.localMaxPrice - this.requiredDistance);
                    }
                },

                /* max price */
                get localMaxPrice() {
                    let maxPrice = this
                        .$refs
                        .maxPrice
                        .value
                        .match(/[\d,]+/g)?.[0]?.replaceAll(',', '');
                    if (!maxPrice) return;
                    return parseInt(maxPrice);
                },
                setLocalMaxPrice(value) {
                    this.$refs.maxPrice.value = value;
                    this.dispatchInputEvent(this.$refs.maxPrice);
                    this.setGlobalMaxPrice(value);
                },
                setGlobalMaxPrice(value) {
                    if (value == this.max) {
                        this.maxPrice = null;
                    } else {
                        this.maxPrice = value;
                    }
                },
                onInputMaxPrice(e) {
                    let maxPrice = this.localMaxPrice;

                    if (maxPrice) this.setGlobalMaxPrice(maxPrice);
                },
                onBlurMaxPrice(e) {
                    let maxPrice = this.localMaxPrice;
                    maxPrice ??= 0;

                    if (maxPrice > this.max) {
                        this.setLocalMaxPrice(this.max);
                    }

                    if (maxPrice - this.requiredDistance < this.localMinPrice) {
                        this.setLocalMaxPrice(this.localMinPrice + this.requiredDistance);
                    }
                },

                /* utils */
                dispatchInputEvent(el) {
                    el.dispatchEvent(new Event('input', {
                        bubbles: true,
                        cancelable: true,
                    }));
                },
            }))
        });
    </script>
@endpush
