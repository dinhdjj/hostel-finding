import './bootstrap';
import { useGoogleMaps } from './use-google-maps';
import { createHtmlMapMarker } from './create-html-map-marker';
import Alpine from 'alpinejs';
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm';

Alpine.plugin(NotificationsAlpinePlugin);

window.Alpine = Alpine;
window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;

Alpine.start();
