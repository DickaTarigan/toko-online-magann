<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
 
// Props yang dikirim dari HomeController
const props = defineProps({
    pesan:   String,
    versi:   String,
});
</script>
 
<template>
    <AppLayout>
        <Head title="Beranda" />
 
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
            <div class="max-w-7xl mx-auto px-4 py-20 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Selamat Datang di Toko Online
                </h1>
                <p class="text-blue-100 text-lg mb-2">{{ pesan }}</p>
                <p class="text-blue-200 text-sm mb-8">Laravel {{ versi }}</p>
                <a href="/products"
                   class="bg-white text-blue-600 font-bold px-8 py-3 rounded-lg hover:bg-blue-50">
                    Mulai Belanja
                </a>
            </div>
        </div>
    </AppLayout>
</template>
