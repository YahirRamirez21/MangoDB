import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css', 
                'resources/css/styleLogin.css',  
                'resources/css/inicio-EA.css',
                'resources/css/styleInicio-EA.css',
                'resources/css/styleInicio-JC.css',
                'resources/css/styleInfoHectarea.css',
                'resources/css/styleIngresaCaja-EA.css',
            ],
        }),
    ],
});
