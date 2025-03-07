import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'localhost',
        // o '127.0.0.1'
    },
    plugins: [
        laravel({
            input: [
                // CSS Global
                'resources/css/app.css',

                // CSS de Layouts
                'resources/css/layouts/navigation.css',
                'resources/css/layouts/footer.css',

                // CSS de Componentes
                'resources/css/components/buttons.css',
                'resources/css/components/card.css',

                // CSS de Páginas
                'resources/css/pages/home.css',
                'resources/css/pages/about.css',
                'resources/css/pages/services.css',
                'resources/css/pages/contact.css',
                'resources/css/pages/legal.css',

                // JS Global
                'resources/js/app.js',

                // JS de Layouts
                'resources/js/layouts/navigation.js',
                'resources/js/layouts/footer.js',

                // JS de Componentes
                'resources/js/components/modal.js',

                // JS de Páginas
                'resources/js/pages/home.js',
                'resources/js/pages/about.js',
                'resources/js/pages/services.js',
                'resources/js/pages/contact.js',
                'resources/js/pages/legal.js'
            ],
            refresh: true,
        }),
    ],
});