import { Loader } from 'google-maps';

import { createHtmlMapMarker } from './create-html-map-marker';
import { debounce } from 'lodash';
import { format } from './number-helpers';
import { useGoogleMaps } from './use-google-maps';

export async function loadHostelMap(element, livewire, options = {}) {
    const center = options.center || {
        lat: 10.847020375198863,
        lng: 106.67645220577741,
    };
    const zoom = options.zoom || 14;
    const minZoom = options.zoom || 7;
    const maxZoom = options.zoom || 19;

    const google = await useGoogleMaps();

    const map = new google.maps.Map(element, {
        center,
        zoom,
        minZoom,
        maxZoom,
    });

    let marks = [];

    function updateHostels(hostels) {
        marks.forEach((mark) => mark.setMap(null));
        marks = [];
        hostels.forEach((hostel) => {
            const mark = createHtmlMapMarker(google, {
                position: new google.maps.LatLng(
                    hostel.latitude,
                    hostel.longitude
                ),
                map: map,
                html: /*html*/ `
                    <div class="relative">
                        <button class="rounded-full border bg-white py-1 px-2 font-extrabold text-gray-800 shadow text-sm">
                            đ${format(hostel.monthly_price)}
                        </button>

                        <div is-popup class="hidden absolute bottom-0 right-0">
                            xin chao ${hostel.title}
                        </div>
                    </div>
                `,
            });

            mark.addListener('click', (e) => {
                const popup =
                    e.target.parentElement.querySelector('[is-popup]');
                popup.classList.toggle('hidden');
            });

            marks.push(mark);
        });
    }

    updateHostels(livewire.hostels);

    const updateDebounceBounds = debounce(async () => {
        const bounds = map.getBounds();
        const north = bounds.getNorthEast().lat();
        const east = bounds.getNorthEast().lng();
        const south = bounds.getSouthWest().lat();
        const west = bounds.getSouthWest().lng();
        await livewire.updateBounds(north, south, west, east);
        updateHostels(livewire.hostels);
    }, 1000);

    let firstly = true;
    map.addListener('bounds_changed', () => {
        if (firstly) {
            firstly = false;
            return;
        }

        updateDebounceBounds();
    });
}
