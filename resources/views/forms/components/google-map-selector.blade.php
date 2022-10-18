<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.{{ $applyStateBindingModifiers("entangle('{$getStatePath()}')") }} }">
        <div x-data="forms_components_google_map_selector">
            <input
                type="text"
                x-ref="searchAddress"
                @keydown.enter.prevent=""
                class="mb-1 w-full rounded-md border border-gray-300"
                placeholder="Tìm kiếm"
            >

            <div
                x-ref="map"
                wire:ignore
                class="h-96 w-full"
            ></div>
        </div>
    </div>
</x-forms::field-wrapper>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('forms_components_google_map_selector', () => ({
            initialCenter: {
                lat: 10.77,
                lng: 106.69
            },
            google: null,
            map: null,
            geocoder: null,
            autocomplete: null,
            address: null,
            marker: null,

            async init() {
                if (this.state?.latitude && this.state?.longitude) {
                    this.initialCenter = {
                        lat: this.state.latitude,
                        lng: this.state.longitude
                    }
                }

                await this.initMap();
                await this.initGeocoder();
                this.initMarker();
                await this.initAutocomplete();
            },

            async initMap() {
                this.google = await window.useGoogleMaps();

                this.map = new this.google.maps.Map(this.$refs.map, {
                    center: this.initialCenter,
                    zoom: 14,
                    maxZoom: 19,
                    minZoom: 7,
                });

                this.map.addListener('center_changed', () => this.onCenterChanged());
            },

            async initGeocoder() {
                this.geocoder = new this.google.maps.Geocoder();
            },

            initMarker() {
                this.marker = new this.google.maps.Marker({
                    position: this.initialCenter,
                    map: this.map,
                    draggable: true,
                    animation: this.google.maps.Animation.DROP,
                });
            },

            async initAutocomplete() {
                this.autocomplete = new this.google.maps.places.Autocomplete(
                    this.$refs.searchAddress
                );
                this.autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
                this.autocomplete.addListener('place_changed', () => this.onPlaceChanged());
            },

            onPlaceChanged() {
                const places = this.autocomplete.getPlace();
                if (places.geometry) {
                    this.center = {
                        lat: places.geometry.location.lat(),
                        lng: places.geometry.location.lng(),
                    };
                    this.map.setCenter(this.center);
                }
            },

            onCenterChanged() {
                const center = this.map.getCenter();
                this.marker.setPosition(this.map.getCenter());

                this.updateState();
            },

            updateState: _.debounce(async function() {
                const center = this.map.getCenter();
                const searchAddress = this.$refs.searchAddress.value;
                let address = searchAddress;

                try {
                    const {
                        results
                    } = await this.geocoder.geocode({
                        location: center
                    });

                    if (results.length > 0) {
                        address = results[0].formatted_address;
                    }
                } catch {}


                this.state = {
                    latitude: this.map.getCenter().lat(),
                    longitude: this.map.getCenter().lng(),
                    search_address: searchAddress,
                    address,
                };
            }, 700),
        }))
    })
</script>
