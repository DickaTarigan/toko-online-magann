<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
 
const props = defineProps({
  stats:          Object,
  recentProducts: Array,
});
const { auth } = usePage().props;
</script>
 
<template>
  <AppLayout>
    <Head title="Dashboard Seller" />
    <div class="max-w-7xl mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-2">
        Selamat datang, {{ auth.user.name }}! 👋
      </h1>
      <p class="text-gray-500 mb-8">Kelola toko dan produk Anda dari sini.</p>
 
      <!-- Stats Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card text-center">
          <p class="text-3xl font-bold text-blue-600">{{ stats.totalProduk }}</p>
          <p class="text-gray-500 text-sm mt-1">Total Produk</p>
        </div>
        <div class="card text-center">
          <p class="text-3xl font-bold text-green-600">{{ stats.produkAktif }}</p>
          <p class="text-gray-500 text-sm mt-1">Produk Aktif</p>
        </div>
        <div class="card text-center">
          <p class="text-3xl font-bold text-purple-600">{{ stats.totalStok }}</p>
          <p class="text-gray-500 text-sm mt-1">Total Stok</p>
        </div>
        <div class="card text-center">
          <p class="text-3xl font-bold text-orange-600">{{ stats.totalPesanan }}</p>
          <p class="text-gray-500 text-sm mt-1">Total Pesanan</p>
        </div>
      </div>
 
      <!-- Produk Terbaru -->
      <div class="card">
        <div class="flex justify-between items-center mb-4">
          <h2 class="font-semibold text-gray-700">Produk Terbaru</h2>
          <Link href="/seller/products" class="text-sm text-blue-600">Lihat Semua →</Link>
        </div>
        <div v-if="recentProducts.length" class="space-y-3">
          <div v-for="p in recentProducts" :key="p.id"
            class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
            <img v-if="p.image_url" :src="p.image_url"
              class="w-12 h-12 object-cover rounded" />
            <div v-else
              class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
            <div class="flex-1 min-w-0">
              <p class="font-medium text-gray-800 truncate">{{ p.name }}</p>
              <p class="text-sm text-gray-400">{{ p.category?.name }}</p>
            </div>
            <span class="font-bold text-blue-600 text-sm">{{ p.formatted_price }}</span>
          </div>
        </div>
        <p v-else class="text-gray-400 text-sm text-center py-8">
          Belum ada produk. <Link href="/seller/products/create"
            class="text-blue-600">Tambah sekarang</Link>
        </p>
      </div>
    </div>
  </AppLayout>
</template>
