import './bootstrap';
import { useGoogleMaps } from './use-google-maps';
import { createHtmlMapMarker } from './create-html-map-marker';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;
window.Alpine = Alpine;

Alpine.start();
