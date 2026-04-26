<script setup>
import { Link, useForm } from '@inertiajs/vue3';
 
const props = defineProps({
  product: Object,
});
 
const deleteForm = useForm({});
 
function handleDelete() {
  // Untuk saat ini kita pakai confirm() bawaan browser.
  // Sederhana, sudah cukup di tahap ini.
  // Di P6 nanti kita akan upgrade ini menjadi modal dialog Vue yang lebih rapi.
  if (confirm(`Hapus produk "${props.product.name}"?`)) {
    deleteForm.delete(`/seller/products/${props.product.id}`);
  }
}
</script>
 
<template>
  <div class="card hover:shadow-md transition-shadow">
 
    <!-- Foto Produk -->
    <div class="relative mb-4">
      <img
        v-if="product.image_url"
        :src="product.image_url"
        :alt="product.name"
        class="w-full h-48 object-cover rounded-lg bg-gray-100"
      />
      <div v-else
        class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center">
        <span class="text-4xl">📦</span>
      </div>
 
      <!-- Badge status -->
      <span
        :class="product.status === 'active'
          ? 'bg-green-100 text-green-700'
          : 'bg-gray-100 text-gray-500'"
        class="absolute top-2 right-2 text-xs px-2 py-1 rounded-full font-medium">
        {{ product.status === 'active' ? 'Aktif' : 'Nonaktif' }}
      </span>
    </div>
 
    <!-- Info Produk -->
    <h3 class="font-semibold text-gray-800 truncate mb-1">{{ product.name }}</h3>
    <p class="text-sm text-gray-400 mb-2">{{ product.category?.name }}</p>
    <div class="flex justify-between items-center mb-4">
      <span class="font-bold text-blue-600">{{ product.formatted_price }}</span>
      <span class="text-sm text-gray-400">Stok: {{ product.stock }}</span>
    </div>
 
    <!-- Tombol Aksi -->
    <div class="flex gap-2">
      <Link
        :href="`/seller/products/${product.id}/edit`"
        class="btn-secondary text-sm flex-1 text-center">
        ✏️ Edit
      </Link>
      <button @click="handleDelete"
        :disabled="deleteForm.processing"
        class="px-3 py-2 text-sm bg-red-50 text-red-600 rounded-lg
               hover:bg-red-100 border border-red-200 transition-colors">
        🗑️
      </button>
    </div>
  </div>
</template>
