import './bootstrap';

import Alpine from 'alpinejs';

import { loadHostelMap } from './load-hostel-map';
import { placeAutocomplete } from './place-autocomplete';

window.loadHostelMap = loadHostelMap;
window.placeAutocomplete = placeAutocomplete;

window.Alpine = Alpine;

Alpine.start();
