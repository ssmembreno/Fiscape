<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const menuOpen = ref(false)

function logout() {
  router.post(route('logout'))
}
</script>

<template #header>
  <div class="flex items-center justify-between w-full relative">

    <!-- Botón del usuario -->
    <div class="relative">
      <button
        @click="menuOpen = !menuOpen"
        class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center hover:ring-2 hover:ring-indigo-500 transition"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A9 9 0 1118.879 6.196a9 9 0 01-13.758 11.608zM12 14a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
      </button>

      <!-- Menú desplegable -->
      <div
        v-if="menuOpen"
        class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-lg z-50"
      >
        <Link
          :href="route('profile.edit')"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          @click="menuOpen = false"
        >
          Ver perfil
        </Link>
        <button
          @click="logout"
          class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
        >
          Cerrar sesión
        </button>
      </div>
    </div>
  </div>
</template>
