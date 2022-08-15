import { Loader } from 'google-maps';
import { useGoogleMaps } from './use-google-maps';

export async function placeAutocomplete(input, options) {
    const google = await useGoogleMaps();

    const autocomplete = new google.maps.places.Autocomplete(input, {
        componentRestrictions: { country: 'VN' },
        fields: ['address_components', 'geometry', 'icon', 'name'],
        strictBounds: false,
    });

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        const latitude = place.geometry?.location.lat();
        const longitude = place.geometry?.location.lng();
        const name = input.value;

        if (options.onPlaceChanged) {
            options.onPlaceChanged({
                latitude,
                longitude,
                name,
            });
        }
    });
}
