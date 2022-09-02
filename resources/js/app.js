import './bootstrap';
import { useGoogleMaps } from './use-google-maps';
import { createHtmlMapMarker } from './create-html-map-marker';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import Focus from '@alpinejs/focus';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm';
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm';

Alpine.plugin(mask);
Alpine.plugin(NotificationsAlpinePlugin);
Alpine.plugin(Focus);
Alpine.plugin(FormsAlpinePlugin);
window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;
window.Alpine = Alpine;
window.useGoogleMaps = useGoogleMaps;
window.createHtmlMapMarker = createHtmlMapMarker;

Alpine.start();
