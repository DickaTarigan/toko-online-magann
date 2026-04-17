import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
 
createInertiaApp({
    // Tab browser akan menampilkan 'Nama Halaman - Toko Online'
    title: (title) => `${title} - Toko Online`,
 
    // Otomatis menemukan file Vue di folder Pages/
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
 
    // Mount Vue ke elemen #app di app.blade.php
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
 
    // Progress bar saat berpindah halaman
    progress: { color: '#2563EB' },
});
