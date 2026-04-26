<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/ProductCard.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
 
const props = defineProps({
  products: Object, // hasil paginate() dari Laravel (berisi data + meta paginasi)
});
 
// Pencarian client-side — hanya memfilter produk di halaman ini.
// Keterbatasan: tidak bisa menemukan produk di halaman paginasi lain.
// Akan diupgrade ke pencarian server-side di P4.
const searchQuery = ref('');
 
const filteredProducts = computed(() => {
  if (!searchQuery.value.trim()) return props.products.data;
  const q = searchQuery.value.toLowerCase();
  return props.products.data.filter(p =>
    p.name.toLowerCase().includes(q) ||
    p.category?.name.toLowerCase().includes(q)
  );
});
</script>
 
<template>
  <AppLayout>
    <Head title="Produk Saya" />
 
    <div class="max-w-7xl mx-auto px-4 py-8">
 
      <!-- Header + Tombol Tambah -->
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">Produk Saya</h1>
          <p class="text-gray-500 text-sm mt-1">
            {{ products.total }} produk terdaftar
          </p>
        </div>
        <Link href="/seller/products/create" class="btn-primary">
          + Tambah Produk
        </Link>
      </div>
 
      <!-- Search Bar -->
      <div class="mb-6">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari nama atau kategori produk..."
          class="input max-w-md"
        />
      </div>
 
      <!-- Grid Produk -->
      <div v-if="filteredProducts.length > 0"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <ProductCard
          v-for="product in filteredProducts"
          :key="product.id"
          :product="product"
        />
      </div>
 
      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <span class="text-6xl">📦</span>
        <p class="text-gray-500 mt-4 text-lg">
          {{ searchQuery ? 'Produk tidak ditemukan.' : 'Belum ada produk.' }}
        </p>
        <Link v-if="!searchQuery"
          href="/seller/products/create"
          class="btn-primary inline-block mt-4">
          Tambah Produk Pertama
        </Link>
      </div>
 
      <!-- Paginasi -->
      <div v-if="products.last_page > 1"
        class="flex justify-center gap-2 mt-8">
        <Link
          v-for="link in products.links"
          :key="link.label"
          :href="link.url ?? '#'"
          v-html="link.label"
          class="px-3 py-2 rounded text-sm border"
          :class="link.active
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-600 hover:bg-gray-50'"
        />
      </div>
    </div>
  </AppLayout>
</template>
