import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/filament-admin.js',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament.css',
                'resources/css/places-autocomplete-dropdown.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
