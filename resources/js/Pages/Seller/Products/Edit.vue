<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputField from '@/Components/InputField.vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
 
const props = defineProps({
  product:    Object,
  categories: Array,
});
 
// Isi form dengan data produk yang sudah ada
const form = useForm({
  name:        props.product.name,
  category_id: props.product.category_id,
  description: props.product.description ?? '',
  price:       props.product.price,
  stock:       props.product.stock,
  status:      props.product.status,
  image:       null,    // null = tidak ganti foto
  _method:     'PUT',   // Laravel method spoofing untuk PUT via POST
});
 
const previewUrl = ref(null); // null = tampilkan foto lama
 
function handleImageChange(event) {
  const file = event.target.files[0];
  if (!file) return;
  form.image = file;
  previewUrl.value = URL.createObjectURL(file);
}
 
function submit() {
  form.post(`/seller/products/${props.product.id}`, { forceFormData: true });
}
</script>
 
<template>
  <AppLayout>
    <Head :title="`Edit: ${product.name}`" />
 
    <div class="max-w-3xl mx-auto px-4 py-8">
      <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <Link href="/seller/products" class="hover:text-blue-600">Produk Saya</Link>
        <span>›</span>
        <span class="text-gray-600">Edit Produk</span>
      </div>
 
      <div class="card">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Edit Produk</h1>
 
        <form @submit.prevent="submit" enctype="multipart/form-data">
 
          <!-- Foto: tampilkan foto lama atau preview baru -->
          <div class="mb-6">
            <label class="label">Foto Produk</label>
            <div class="mt-1">
              <div class="mb-3 w-full h-48 rounded-lg overflow-hidden bg-gray-100">
                <img
                  :src="previewUrl ?? product.image_url ?? ''"
                  v-if="previewUrl || product.image_url"
                  class="w-full h-full object-cover" alt="Foto produk" />
                <div v-else
                  class="w-full h-full flex items-center justify-center text-4xl">
                  📦
                </div>
              </div>
              <p class="text-xs text-gray-400 mb-2">
                {{ previewUrl ? '✅ Foto baru dipilih' : 'Biarkan kosong jika tidak ingin mengganti foto' }}
              </p>
              <label class="cursor-pointer flex items-center gap-3 p-3 border border-dashed
                          border-gray-300 rounded-lg hover:border-blue-400 transition-colors">
                <span>📷</span>
                <span class="text-sm text-gray-600">Klik untuk ganti foto</span>
                <input type="file" accept="image/*"
                  @change="handleImageChange" class="hidden" />
              </label>
            </div>
          </div>
 
          <!-- Field sama dengan Create.vue -->
          <div class="grid grid-cols-2 gap-4">
            <InputField label="Nama Produk *" v-model="form.name"
              :error="form.errors.name" />
            <div class="mb-4">
              <label class="label">Kategori *</label>
              <select v-model="form.category_id" class="input">
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="label">Harga (Rp) *</label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">Rp</span>
                <input type="number" v-model="form.price" class="input pl-10" />
              </div>
            </div>
            <InputField label="Stok *" type="number" v-model="form.stock" />
          </div>
          <div class="mb-4">
            <label class="label">Deskripsi</label>
            <textarea v-model="form.description" rows="4" class="input"></textarea>
          </div>
          <div class="mb-6">
            <label class="label">Status</label>
            <div class="flex gap-4">
              <label class="flex items-center gap-2">
                <input type="radio" v-model="form.status" value="active" />
                <span class="text-sm">Aktif</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" v-model="form.status" value="inactive" />
                <span class="text-sm">Nonaktif</span>
              </label>
            </div>
          </div>
 
          <div class="flex gap-3">
            <button type="submit" class="btn-primary" :disabled="form.processing">
              {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
            <Link href="/seller/products" class="btn-secondary">Batal</Link>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
