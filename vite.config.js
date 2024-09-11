import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', `resources/css/filament/user/theme.css`, `resources/css/filament/agent/theme.css`],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'app/Forms/Components/**',
            ],
        }),
    ],
});
