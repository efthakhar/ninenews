import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [

                'resources/js/app.js',

                // Admin Assets
                "resources/assets/admin/js/dashboard-core.js",
                "resources/assets/admin/css/dashboard-core.css",

                "resources/assets/admin/js/tag.js",
            ],
            refresh: true,
        }),
    ],
});
