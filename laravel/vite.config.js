import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    server: {
        host: true,
        port: 3000,
        strictPort: true,

        hmr: {
            host: 'localhost'
        },
        watch: {
            usePolling: true
        },

        // cors: {
        //     origin: 'http://46.147.218.41:81',
        // },

    },
    preview: {
        host: true,
        port: 3001,
        strictPort: true,
    },
    base: './',
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @import "./resources/scss/_variables.scss";
                `,
                includePaths: [path.resolve(__dirname, 'resources/scss')],
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss'
                // 'public/build/assets/app-9f25df27.js',
                // 'public/build/assets/app-12e35062.css',p
            ],
            refresh: true,
            buildDirectory: 'public/build'
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // Плагин Vue перепишет URL-адреса ресурсов, когда они
                    // будут использоваться в однофайловых компонентах,
                    // чтобы указывать на веб-сервер Laravel. Установка этого
                    // значения в `null` позволяет вместо этого плагину Laravel
                    // переписывать URL-адреса ресурсов, чтобы они указывали на сервер Vite.
                    base: null,

                    // Плагин Vue будет анализировать абсолютные URL-адреса и рассматривать
                    // их как абсолютные пути к файлам на диске. Установка этого значения в
                    // `false` оставит абсолютные URL-адреса нетронутыми, чтобы они могли
                    // ссылаться на ресурсы в папке public, как ожидается.
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: 'asset.json',
        sourcemap: true,
    },

});
