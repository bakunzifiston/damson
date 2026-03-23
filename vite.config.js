import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

/**
 * Vite builds frontend assets for Laravel.
 *
 * Design / styling:
 * - Edit `resources/css/app.css` (Tailwind v4 + @theme + @layer components).
 * - Blade views under `resources/views` are scanned via @source in app.css.
 *
 * Development: `npm run dev` (with `php artisan serve`) for instant CSS updates.
 * Production:  `npm run build` or `npm run build:clean` for a fresh `public/build`.
 */
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build: {
        // Remove old hashed files so the browser never keeps stale CSS/JS.
        emptyOutDir: true,
        // Slightly faster builds; sizes still appear in the build log summary.
        reportCompressedSize: false,
    },
});
