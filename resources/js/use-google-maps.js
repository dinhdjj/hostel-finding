import { Loader } from 'google-maps';
import { once } from 'lodash';

export const useGoogleMaps = once(async () => {
    const loader = new Loader(import.meta.env.VITE_GOOGLE_MAPS_API_KEY, {
        libraries: ['places'],
    });

    return await loader.load();
});
