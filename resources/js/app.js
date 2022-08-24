import './bootstrap';
import { useGoogleMaps } from './use-google-maps';
import Alpine from 'alpinejs';

window.useGoogleMaps = useGoogleMaps;
window.Alpine = Alpine;

Alpine.start();
