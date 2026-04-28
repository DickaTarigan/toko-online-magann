<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductPublicCard from '@/Components/ProductPublicCard.vue';
import { Head, Link } from '@inertiajs/vue3';
 
defineProps({
  pesan:    String,
  versi:    String,
  featured: Array,
});
</script>
 
<template>
  <AppLayout>
    <Head title="Beranda" />
 
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
      <div class="max-w-7xl mx-auto px-4 py-24 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
          Selamat Datang di Toko Online Magann
        </h1>
        <p class="text-blue-100 text-lg mb-8">{{ pesan }}</p>
        <Link href="/products"
          class="bg-white text-blue-600 font-bold px-10 py-4 rounded-xl
                 hover:bg-blue-50 text-lg inline-block">
          Mulai Belanja →
        </Link>
      </div>
    </div>
 
    <!-- Produk Unggulan -->
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Produk Terbaru</h2>
        <Link href="/products" class="text-blue-600 text-sm font-medium hover:underline">
          Lihat Semua →
        </Link>
      </div>
 
      <div v-if="featured.length"
        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <ProductPublicCard
          v-for="product in featured"
          :key="product.id"
          :product="product"
        />
      </div>
      <div v-else class="text-center py-12 text-gray-400">
        <p>Belum ada produk. Seller bisa menambahkan di dashboard mereka.</p>
      </div>
    </div>
  </AppLayout>
</template>
