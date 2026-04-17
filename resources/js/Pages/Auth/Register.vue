<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import InputField from '@/Components/InputField.vue';

const form = useForm({
     name:                  '',
     email:                 '',    
     password:              '',
     password_confirmation: '',
     role:                  'buyer', //default: buyer
})

function submit() {
     form.post('/register');
}
</script>

<template>
     <Head title="Daftar" />

     <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
          <div class="card w-full max-w-md">

               <!-- Header -->
               <div class="text-center mb-8">
                    <Link href="/" class="text-2xl font-bold text-blue-600">🛍️ Toko Online</Link>
                    <h1 class="mt-4 text-xl font-semibold text-gray-800>Buat Akun Baru"></h1>
                    <p class="text-gray-text-500 text-sm mt-1">sudah punya akun?
                         <Link href="/login" class="text-blue-600 font-medium">Masuk di sini</Link>
                    </p>
               </div>

               <div class="mb-6">
                    <label class="label">Daftar sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                         <button type="button"
                              @click="form.role = 'buyer'"
                              :class="form.role === 'buyer'
                                   ? 'bg-blue-600 text-white border-blue-600'
                                   : 'bg-white text-gray-600 border-gray-300'"
                              class="py-3 rounded-lg border-2 font-semibold transition-all">
                              🛒 Pembeli
                         </button>
                         <button type="button"
                         @click="form.role = 'seller'"
                         :class="form.role === 'seller'
                              ? 'bg-blue-600 text-white border-blue-600'
                              : 'bg-white text-gray-600 border-gray-300'"
                         class="py-3 rounded-lg border-2 font-semibold transition-all">
                         🏪 Penjual
                    </button>
                    </div>
               </div>

               <!-- Form Field-->
                <form @submit.prevent="submit">
                    <InputField label="Nama Lengkap" v-model="form.name"
                         placeholder="Masukkan nama Anda" :error="form.errors.name" />
                    <InputField label="Email" type="email" v-model="form.email"
                         placeholder="nama@email.com" :error="form.errors.email" />
                    <InputField label="Password" type="password" v-model="form.password"
                         placeholder="Minimal 8 karakter" :error="form.errors.password" />
                    <InputField label="Konfirmasi Password" type="password" v-model="form.password_confirmation"
                         placeholder="Ulangi password" />

                    <button type="submit" class="btn-primary w-full m-2"
                         :disable="form.processing">
                         {{ form.processing ? 'Memproses...' : 'Daftar Sekarang' }}
                    </button>
                </form>
          </div>
     </div>
</template>