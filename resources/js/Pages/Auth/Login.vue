<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import InputField from '@/Components/InputField.vue';
 
const form = useForm({
  email:    '',
  password: '',
  remember: false,
});
 
function submit() {
  form.post('/login', {
    onFinish: () => form.reset('password'),  // hapus password dari memory
  });
}
</script>
 
<template>
  <Head title="Masuk" />
 
  <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="card w-full max-w-md">
 
      <div class="text-center mb-8">
        <Link href="/" class="text-2xl font-bold text-blue-600">🛍️ Toko Online</Link>
        <h1 class="mt-4 text-xl font-semibold text-gray-800">Masuk ke Akun Anda</h1>
        <p class="text-gray-500 text-sm mt-1">Belum punya akun?
          <Link href="/register" class="text-blue-600 font-medium">Daftar di sini</Link>
        </p>
      </div>
 
      <form @submit.prevent="submit">
        <InputField label="Email" type="email" v-model="form.email"
          placeholder="nama@email.com" :error="form.errors.email" />
        <InputField label="Password" type="password" v-model="form.password"
          placeholder="Password Anda" :error="form.errors.password" />
 
        <!-- Remember me -->
        <div class="flex items-center justify-between mb-6">
          <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" v-model="form.remember" class="rounded">
            Ingat saya
          </label>
        </div>
 
        <button type="submit" class="btn-primary w-full"
          :disabled="form.processing">
          {{ form.processing ? 'Memproses...' : 'Masuk' }}
        </button>
      </form>
    </div>
  </div>
</template>
