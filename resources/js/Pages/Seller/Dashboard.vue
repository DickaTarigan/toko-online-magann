<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
 
defineProps({
  stats: Object,
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
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card text-center">
          <p class="text-3xl font-bold text-blue-600">{{ stats.totalProduk }}</p>
          <p class="text-gray-500 mt-1">Total Produk</p>
        </div>
        <div class="card text-center">
          <p class="text-3xl font-bold text-green-600">{{ stats.totalPesanan }}</p>
          <p class="text-gray-500 mt-1">Total Pesanan</p>
        </div>
        <div class="card text-center">
          <p class="text-3xl font-bold text-purple-600">
            Rp {{ stats.totalPendapatan.toLocaleString('id-ID') }}
          </p>
          <p class="text-gray-500 mt-1">Total Pendapatan</p>
        </div>
      </div>
 
      <!-- Quick Actions -->
      <div class="card">
        <h2 class="font-semibold text-gray-700 mb-4">Aksi Cepat</h2>
        <div class="flex gap-3">
          <Link href="/seller/products/create" class="btn-primary">
            + Tambah Produk
          </Link>
        </div>
        <p class="text-sm text-gray-400 mt-3">Fitur manajemen produk akan aktif di P3.</p>
      </div>
    </div>
  </AppLayout>
</template>
