<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isOpen = ref(false);
</script>

<template>
  <!-- Sidebar -->
  <aside
    class="bg-[#EAEFEF] border-r shadow-sm h-full min-h-screen flex flex-col fixed lg:static top-0 left-0 z-40 w-64 lg:w-auto transform lg:translate-x-0 transition-transform duration-300"
    :class="{ '-translate-x-full': !isOpen }"
  >
    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b">
      <Link :href="route('dashboard')" class="flex items-center gap-2">
        <div class="h-8 w-8 rounded-xl bg-indigo-600"></div>
        <span class="font-semibold text-lg">Fiscape</span>
      </Link>
    </div>

    <!-- Navegación -->
    <nav class="p-4 space-y-6 text-sm flex-1 overflow-y-auto">
      <div>
        <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Main</p>
        <ul class="space-y-1">
          <li>
            <Link
              :href="route('dashboard')"
              class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100"
              :class="{ 'bg-gray-100 font-medium': route().current('dashboard') }"
            >
              🏠 Dashboard
            </Link>
          </li>
          <li>
            <Link
              :href="route('transactionsIndex')"
              class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100"
              :class="{ 'bg-gray-100 font-medium': route().current('transactions.*') }"
            >
              💸 Transacciones
            </Link>
          </li>
          <li>
            <Link :href="route('categoriesIndex')"
              class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100"
              :class="{ 'bg-gray-100 font-medium': route().current('categories.*') }"
            >
              🏷️ Categorías
            </Link>
          </li>
          <li>
            <Link :href="route('accountsIndex')" 
                class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100"
                :class="{ 'bg-gray-100 font-medium': route().current('accounts.*') }">
              🏦 Cuentas & Tarjetas
            </ Link>
          </li>
        </ul>
      </div>

      <div>
        <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Administración</p>
        <ul class="space-y-1">
          <li>
            <a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">👤 Usuarios</a>
          </li>
          <li>
            <a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">⚙️ Ajustes</a>
          </li>
          <li>
            <a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🧾 Auditoría</a>
          </li>
        </ul>
      </div>
    </nav>
  </aside>
</template>
