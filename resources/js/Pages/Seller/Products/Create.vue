<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputField from '@/Components/InputField.vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
 
defineProps({
  categories: Array,
});
 
const form = useForm({
  name:        '',
  category_id: '',
  description: '',
  price:       '',
  stock:       0,
  status:      'active',
  image:       null,
});
 
// Untuk preview foto sebelum diupload
const previewUrl = ref(null);
 
function handleImageChange(event) {
  const file = event.target.files[0];
  if (!file) return;
  form.image = file;
  // Buat URL sementara untuk preview di browser
  previewUrl.value = URL.createObjectURL(file);
}
 
function submit() {
  // forceFormData: paksa kirim sebagai multipart (wajib untuk file upload)
  form.post('/seller/products', { forceFormData: true });
}
</script>
 
<template>
  <AppLayout>
    <Head title="Tambah Produk" />
 
    <div class="max-w-3xl mx-auto px-4 py-8">
      <!-- Breadcrumb -->
      <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <Link href="/seller/products" class="hover:text-blue-600">Produk Saya</Link>
        <span>›</span>
        <span class="text-gray-600">Tambah Produk</span>
      </div>
 
      <div class="card">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h1>
 
        <form @submit.prevent="submit" enctype="multipart/form-data">
 
          <!-- Upload Foto -->
          <div class="mb-6">
            <label class="label">Foto Produk *</label>
            <div class="mt-1">
              <!-- Preview -->
              <div v-if="previewUrl"
                class="mb-3 w-full h-48 rounded-lg overflow-hidden bg-gray-100">
                <img :src="previewUrl" class="w-full h-full object-cover" alt="Preview" />
              </div>
              <!-- Input file -->
              <label class="cursor-pointer flex items-center gap-3 p-4 border-2
                          border-dashed border-gray-300 rounded-lg hover:border-blue-400
                          hover:bg-blue-50 transition-colors">
                <span class="text-2xl">📷</span>
                <div>
                  <p class="text-sm font-medium text-gray-700">
                    {{ previewUrl ? 'Ganti foto' : 'Klik untuk pilih foto' }}
                  </p>
                  <p class="text-xs text-gray-400">JPG, PNG, WebP — Maks. 2MB</p>
                </div>
                <input type="file" accept="image/*"
                  @change="handleImageChange" class="hidden" />
              </label>
              <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">
                {{ form.errors.image }}
              </p>
            </div>
          </div>
 
          <!-- Nama & Kategori dalam 2 kolom -->
          <div class="grid grid-cols-2 gap-4">
            <InputField label="Nama Produk *" v-model="form.name"
              placeholder="Contoh: Kemeja Batik Pria" :error="form.errors.name" />
 
            <div class="mb-4">
              <label class="label">Kategori *</label>
              <select v-model="form.category_id" class="input"
                :class="{ 'border-red-500': form.errors.category_id }">
                <option value="">-- Pilih Kategori --</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
              <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-600">
                {{ form.errors.category_id }}
              </p>
            </div>
          </div>
 
          <!-- Harga & Stok -->
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="label">Harga (Rp) *</label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">Rp</span>
                <input type="number" v-model="form.price" min="100"
                  class="input pl-10" :class="{ 'border-red-500': form.errors.price }"
                  placeholder="50000" />
              </div>
              <p v-if="form.errors.price" class="mt-1 text-sm text-red-600">
                {{ form.errors.price }}
              </p>
            </div>
            <InputField label="Stok *" type="number" v-model="form.stock"
              :error="form.errors.stock" />
          </div>
 
          <!-- Deskripsi -->
          <div class="mb-4">
            <label class="label">Deskripsi</label>
            <textarea v-model="form.description" rows="4"
              class="input" placeholder="Jelaskan detail produk Anda..."></textarea>
          </div>
 
          <!-- Status -->
          <div class="mb-6">
            <label class="label">Status Produk</label>
            <div class="flex gap-4">
              <label class="flex items-center gap-2">
                <input type="radio" v-model="form.status" value="active" />
                <span class="text-sm">Aktif (tampil di toko)</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" v-model="form.status" value="inactive" />
                <span class="text-sm">Nonaktif (disembunyikan)</span>
              </label>
            </div>
          </div>
 
          <!-- Tombol Submit -->
          <div class="flex gap-3">
            <button type="submit" class="btn-primary" :disabled="form.processing">
              {{ form.processing ? 'Menyimpan...' : 'Simpan Produk' }}
            </button>
            <Link href="/seller/products" class="btn-secondary">Batal</Link>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
