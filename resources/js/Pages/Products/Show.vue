<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductPublicCard from '@/Components/ProductPublicCard.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
 
const props = defineProps({
  product: Object,
  related: Array,
});
 
// Cek apakah user sudah login (untuk tombol 'Tambah ke Keranjang' di P5)
const { auth } = usePage().props;
const isLoggedIn = computed(() => !!auth.user);
</script>
 
<template>
  <AppLayout>
    <Head :title="product.name" />
 
    <div class="max-w-7xl mx-auto px-4 py-8">
 
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <Link href="/" class="hover:text-blue-600">Beranda</Link>
        <span>›</span>
        <Link href="/products" class="hover:text-blue-600">Produk</Link>
        <span>›</span>
        <span class="text-gray-600 truncate max-w-xs">{{ product.name }}</span>
      </nav>
 
      <!-- Layout Dua Kolom: Foto | Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
 
        <!-- Kolom Kiri: Foto -->
        <div>
          <div class="rounded-2xl overflow-hidden bg-gray-100 aspect-square">
            <img
              v-if="product.image_url"
              :src="product.image_url"
              :alt="product.name"
              class="w-full h-full object-cover"
            />
            <div v-else
              class="w-full h-full flex items-center justify-center text-8xl">
              📦
            </div>
          </div>
        </div>
 
        <!-- Kolom Kanan: Informasi Produk -->
        <div class="flex flex-col">
 
          <!-- Kategori -->
          <Link
            :href="`/products?category=${product.category_id}`"
            class="text-sm text-blue-500 font-medium hover:underline mb-2 w-fit">
            {{ product.category?.name }}
          </Link>
 
          <!-- Nama Produk -->
          <h1 class="text-2xl font-bold text-gray-800 mb-3 leading-snug">
            {{ product.name }}
          </h1>
 
          <!-- Penjual -->
          <p class="text-sm text-gray-400 mb-6">
            Dijual oleh <span class="font-medium text-gray-600">
              {{ product.seller?.name ?? 'Toko Online' }}
            </span>
          </p>
 
          <!-- Harga -->
          <p class="text-3xl font-bold text-blue-600 mb-4">
            {{ product.formatted_price }}
          </p>
 
          <!-- Stok -->
          <div class="flex items-center gap-2 mb-6">
            <span
              :class="product.stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'"
              class="text-sm px-3 py-1 rounded-full font-medium">
              {{ product.stock > 0 ? `Stok: ${product.stock}` : 'Habis' }}
            </span>
          </div>
 
          <!-- Tombol Aksi -->
          <div class="flex gap-3 mb-8">
            <button
              v-if="product.stock > 0"
              class="btn-primary flex-1 py-3"
              :disabled="!isLoggedIn"
              :title="!isLoggedIn ? 'Login dulu untuk membeli' : ''"
            >
              🛒 Tambah ke Keranjang
            </button>
            <button v-else class="flex-1 py-3 bg-gray-100 text-gray-400
              rounded-lg font-semibold cursor-not-allowed">
              Stok Habis
            </button>
          </div>
 
          <!-- Catatan login -->
          <p v-if="!isLoggedIn && product.stock > 0"
            class="text-sm text-gray-400 mb-6">
            <Link href="/login" class="text-blue-600 font-medium">Masuk</Link>
            atau
            <Link href="/register" class="text-blue-600 font-medium">Daftar</Link>
            untuk membeli produk ini.
          </p>
 
          <!-- Deskripsi -->
          <div class="border-t pt-6">
            <h2 class="font-semibold text-gray-700 mb-3">Deskripsi Produk</h2>
            <p class="text-gray-600 leading-relaxed whitespace-pre-line">
              {{ product.description ?? 'Tidak ada deskripsi.' }}
            </p>
          </div>
        </div>
      </div>
 
      <!-- Produk Terkait -->
      <div v-if="related.length > 0">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <ProductPublicCard
            v-for="item in related"
            :key="item.id"
            :product="item"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
