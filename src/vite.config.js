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
                'resources/js/configuracion/asignacion-economica.js',
                // Nuevos scripts para parámetros del sistema
                'resources/js/parametros/tabs.js',
                'resources/js/parametros/parametros-economicos.js',
                'resources/js/parametros/items-cobro.js',
                'resources/js/parametros/materias.js',
                'resources/js/parametros/index.js',
                // Scripts para carreras
                'resources/js/academico/carrera/show.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
