<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
 
// Ambil shared props dari Inertia
const page = usePage();
const auth = computed(() => page.props.auth);
const flash = computed(() => page.props.flash);
 
// Form logout (pakai POST untuk keamanan CSRF)
const logoutForm = useForm({});
function logout() {
  logoutForm.post('/logout');
}
</script>
 
<template>
  <div class="min-h-screen bg-gray-50">
 
    <!-- Flash Messages -->
    <div v-if="flash.success"
      class="bg-green-50 border-b border-green-200 text-green-800 text-sm px-4 py-2 text-center">
      ✅ {{ flash.success }}
    </div>
 
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <Link href="/" class="text-xl font-bold text-blue-600">🛍️ Toko Online</Link>
 
        <div class="flex items-center gap-4">
          <Link href="/products" class="text-gray-600 hover:text-blue-600 text-sm">Produk</Link>
 
          <!-- Jika SUDAH login -->
          <template v-if="auth.user">
            <!--Link untuk Profil-->
            <Link href="/profile" class="text-gray-600 hover:text-blue-600 text-sm">
              Profil
            </Link>

            <!-- Link dashboard khusus seller -->
            <Link v-if="auth.user.role === 'seller'"
              href="/seller/dashboard"
              class="text-gray-600 hover:text-blue-600 text-sm">
              Dashboard
            </Link>
 
            <!-- Nama user dan tombol logout -->
            <span class="text-sm text-gray-600">{{ auth.user.name }}</span>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
              {{ auth.user.role }}
            </span>
            <button @click="logout" class="btn-secondary text-sm">Keluar</button>
          </template>
 
          <!-- Jika BELUM login -->
          <template v-else>
            <Link href="/login" class="text-gray-600 hover:text-blue-600 text-sm">Masuk</Link>
            <Link href="/register" class="btn-primary text-sm">Daftar</Link>
          </template>
        </div>
      </div>
    </nav>
 
    <main><slot /></main>
  </div>
</template>
