import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite'; // <--- Tambahkan ini

export default defineConfig({
    server: {
        host: '0.0.0.0', // Agar bisa diakses dari luar
        hmr: {
            host: 'localhost', // GANTI dengan IP laptop kamu (hasil ipconfig tadi)
        },
    },

    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // auto-reload saat file PHP berubah
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(), // <--- Nyalakan mesin Tailwind v4 di sini
    ],
});