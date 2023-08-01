import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/header/OnSlope.js',
            'resources/js/skins/AnimationsManager.js',
            'resources/js/skins/NameScroll.js',
            'resources/js/skins/ResizeIndexComponent.js',
            'resources/js/skins/ScrollListeners.js',
            'resources/js/twitch/twitch_embed.js',
        ]),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
});
