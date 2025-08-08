import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/auth/auth.js',
                'resources/js/configuracion/roles.js',
                'resources/js/configuracion/funciones.js',
                'resources/js/configuracion/parametros-economicos-simple.js',
                'resources/js/configuracion/asignacion-economica.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
