<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductPublicCard from '@/Components/ProductPublicCard.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
 
const props = defineProps({
  products:   Object,  // hasil paginate() dari Laravel
  categories: Array,
  filters:    Object,  // { search, category, sort } — nilai aktif saat ini
});
 
// Inisialisasi input dari filter yang sudah aktif (penting saat user
// refresh halaman atau kembali dari halaman detail)
const search     = ref(props.filters.search     ?? '');
const categoryId = ref(props.filters.categoryId   ?? '');
const sort       = ref(props.filters.sort       ?? 'latest');
 
// ── Fungsi utama: kirim filter ke server ─────────────────────────────
function applyFilters() {
  // router.get() dari Inertia: navigasi SPA ke URL baru dengan query string
  // preserveScroll: halaman tidak melompat ke atas setiap kali filter berubah
  router.get('/products', {
    search:   search.value   || undefined,  // undefined = tidak dikirim ke URL
    category: categoryId.value || undefined,
    sort:     sort.value !== 'latest' ? sort.value : undefined,
  }, {
    preserveScroll: true,
    preserveState: true, //agar kursor tidak berpindah
    replace: true,  // ganti history, bukan tambah entry baru
  });
}
 
// ── Debounce pencarian: tunggu 400ms setelah user berhenti mengetik ──
// Tanpa debounce, setiap huruf yang diketik akan kirim 1 request ke server.
let debounceTimer = null;
watch(search, () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(applyFilters, 400);
});
 
// Kategori dan sort langsung apply tanpa debounce
watch([categoryId, sort], applyFilters);
 
function clearFilters() {
  search.value     = '';
  categoryId.value = '';
  sort.value       = 'latest';
  // watch akan otomatis memanggil applyFilters()
}
 
// Apakah ada filter yang aktif?
const hasActiveFilters = () =>
  search.value || categoryId.value || sort.value !== 'latest';
</script>
 
<template>
  <AppLayout>
    <Head title="Katalog Produk" />
 
    <div class="max-w-7xl mx-auto px-4 py-8">
 
      <!-- Header Halaman -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Katalog Produk</h1>
        <p class="text-gray-500 mt-1">
          {{ products.total }} produk tersedia
        </p>
      </div>
 
      <!-- Panel Filter -->
      <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-8">
        <div class="flex flex-col md:flex-row gap-3">
 
          <!-- Kotak Pencarian -->
          <div class="flex-1 relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
            <input
              v-model="search"
              type="text"
              placeholder="Cari produk..."
              class="input pl-10"
            />
          </div>
 
          <!-- Dropdown Kategori -->
          <select v-model="categoryId" class="input md:w-48">
            <option value="">Semua Kategori</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
              {{ cat.name }}
            </option>
          </select>
 
          <!-- Dropdown Urutan -->
          <select v-model="sort" class="input md:w-48">
            <option value="latest">Terbaru</option>
            <option value="price_asc">Harga: Termurah</option>
            <option value="price_desc">Harga: Termahal</option>
            <option value="name_asc">Nama A–Z</option>
          </select>
 
          <!-- Tombol Reset Filter -->
          <button
            v-if="hasActiveFilters()"
            @click="clearFilters"
            class="btn-secondary whitespace-nowrap">
            ✕ Reset
          </button>
        </div>
 
        <!-- Indikator filter aktif -->
        <div v-if="hasActiveFilters()" class="mt-3 flex gap-2 flex-wrap">
          <span v-if="search"
            class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
            Kata kunci: "{{ search }}"
          </span>
          <span v-if="categoryId"
            class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
            Kategori dipilih"
          </span>
        </div>
      </div>
 
      <!-- Grid Produk -->
      <div v-if="products.data.length > 0"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <ProductPublicCard
          v-for="product in products.data"
          :key="product.id"
          :product="product"
        />
      </div>
 
      <!-- Empty State -->
      <div v-else class="text-center py-24">
        <span class="text-6xl">🔍</span>
        <h3 class="text-xl font-semibold text-gray-700 mt-4">Produk tidak ditemukan</h3>
        <p class="text-gray-400 mt-2">
          Coba kata kunci lain atau hapus filter yang aktif.
        </p>
        <button @click="clearFilters" class="btn-primary mt-6">
          Tampilkan Semua Produk
        </button>
      </div>
 
      <!-- Paginasi -->
      <div v-if="products.last_page > 1"
        class="flex justify-center gap-2 mt-10 flex-wrap">
        <Link
          v-for="link in products.links"
          :key="link.label"
          :href="link.url ?? '#'"
          v-html="link.label"
          class="px-4 py-2 rounded-lg text-sm border"
          :class="link.active
            ? 'bg-blue-600 text-white border-blue-600 font-semibold'
            : link.url
              ? 'bg-white text-gray-600 hover:bg-gray-50 border-gray-200'
              : 'bg-gray-50 text-gray-300 border-gray-100 cursor-not-allowed'"
        />
      </div>
    </div>
  </AppLayout>
</template>
