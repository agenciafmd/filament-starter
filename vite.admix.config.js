import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            hotFile: 'public/filament-admix.hot',
            buildDirectory: 'filament-admix',
            input: [
                'resources/css/filament/filament-admix/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
