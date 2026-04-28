<script setup>
import { Link } from '@inertiajs/vue3';
 
defineProps({
  product: Object,
});
</script>
 
<template>
  <div class="card hover:shadow-md transition-shadow group">
 
    <!-- Foto Produk -->
    <Link :href="`/products/${product.slug}`">
      <div class="relative mb-4 overflow-hidden rounded-lg">
        <img
          v-if="product.image_url"
          :src="product.image_url"
          :alt="product.name"
          class="w-full h-48 object-cover bg-gray-100
                 group-hover:scale-105 transition-transform duration-300"
        />
        <div v-else
          class="w-full h-48 bg-gray-100 flex items-center justify-center">
          <span class="text-5xl">📦</span>
        </div>
      </div>
    </Link>
 
    <!-- Info Produk -->
    <p class="text-xs text-blue-500 font-medium mb-1">
      {{ product.category?.name }}
    </p>
    <Link :href="`/products/${product.slug}`">
      <h3 class="font-semibold text-gray-800 hover:text-blue-600
                  line-clamp-2 mb-2 leading-snug">
        {{ product.name }}
      </h3>
    </Link>
 
    <!-- Penjual -->
    <p class="text-xs text-gray-400 mb-3">
      oleh {{ product.seller?.name ?? 'Toko Online' }}
    </p>
 
    <!-- Harga & Stok -->
    <div class="flex justify-between items-center mb-4">
      <span class="text-lg font-bold text-blue-600">
        {{ product.formatted_price }}
      </span>
      <span class="text-xs text-gray-400">
        Stok: {{ product.stock }}
      </span>
    </div>
 
    <!-- Tombol Lihat Detail -->
    <Link
      :href="`/products/${product.slug}`"
      class="btn-primary w-full text-center text-sm block">
      Lihat Detail
    </Link>
  </div>
</template>
