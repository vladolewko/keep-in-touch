import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            'resources/js/like-publication.js',
            'resources/js/repost-publication.js',
            'resources/js/comment-menu.js',
            ],
            refresh: true,
        }),
    ],
});
