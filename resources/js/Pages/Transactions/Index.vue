<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Pencil, Trash2 } from 'lucide-vue-next'
import ConfirmModal from '@/components/ConfirmModal.vue'
import { ref } from 'vue'
import Alerts from '@/components/Alerts.vue'

const props = defineProps({
  transactions: Array,
  categories: Array,
})

// Estado del modal y transacción seleccionada
const showModal = ref(false)
const transactionToDelete = ref(null)

// Abrir modal de confirmación
const confirmDelete = (id) => {
  transactionToDelete.value = id
  showModal.value = true
}

// Eliminar transacción
const deleteTransaction = () => {
  if (!transactionToDelete.value) return
  router.delete(route('transactions.destroy', transactionToDelete.value), {
    onFinish: () => {
      showModal.value = false
      transactionToDelete.value = null
    },
  })
}
</script>

<template>
  <Head title="Transacciones" />

  <DashboardLayout>
    <!--Header -->
    <template #header>
      <div class="flex items-center justify-between w-full">
        <nav class="text-sm text-gray-500">
          <ol class="flex items-center gap-1">
            <li>
              <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
            </li>
            <li>/</li>
            <li class="text-gray-700 font-medium">Transacciones</li>
          </ol>
        </nav>

        <button
          class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center hover:ring-2 hover:ring-indigo-500 transition"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A9 9 0 1118.879 6.196a9 9 0 01-13.758 11.608zM12 14a4 4 0 100-8 4 4 0 000 8z" />
          </svg>
        </button>
      </div>
    </template>

    <!-- Barra de herramientas -->
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="flex items-center gap-2 w-full sm:w-auto">
        <!-- Buscador -->
        <div class="relative w-full sm:w-64">
          <input
            type="text"
            placeholder="Buscar transacciones..."
            class="w-full pl-10 pr-4 py-2 border rounded-md text-sm focus:ring-2 focus:ring-[#84cc16] focus:border-[#84cc16] outline-none"
          />
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-4 w-4 text-gray-400"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
          </svg>
        </div>

        <!-- Selector de cantidad -->
        <button
          class="flex items-center gap-2 border rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          10
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
      </div>

      <!-- Derecha -->
      <div class="flex items-center gap-2">
        <button
          class="inline-flex items-center gap-2 px-4 py-2 text-sm border rounded-md hover:bg-gray-50 transition"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 14.414V20a1 1 0 01-1.447.894l-4-2A1 1 0 018 18v-3.586L3.293 6.707A1 1 0 013 6V4z"/>
          </svg>
          Filtros
        </button>

        <Link
          :href="route('transactionsCreate')"
          class="inline-flex items-center gap-1 px-2 py-1.5 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
          style="background-color: #84cc16;"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
          </svg>
          Nueva Transacción
        </Link>
      </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mt-4 overflow-x-auto">
      <table class="w-full text-sm text-left border-collapse">
        <thead>
          <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
            <th class="px-4 py-3">Fecha</th>
            <th class="px-4 py-3">Tipo</th>
            <th class="px-4 py-3">Categoría</th>
            <th class="px-4 py-3">Monto</th>
            <th class="px-4 py-3">Descripción</th>
            <th class="px-4 py-3 text-right">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="t in props.transactions"
            :key="t.id"
            class="border-b hover:bg-gray-50 transition"
          >
            <td class="px-4 py-2">{{ t.date }}</td>
            <td class="px-4 py-2">
              <span
                class="font-medium"
                :class="t.type === 1 ? 'text-green-600' : 'text-red-600'"
              >
                {{ t.type === 1 ? 'Ingreso' : 'Gasto' }}
              </span>
            </td>
            <td class="px-4 py-2">{{ t.category?.name || '-' }}</td>
            <td class="px-4 py-2 font-semibold">{{ parseFloat(t.amount).toFixed(2) }} €</td>
            <td class="px-4 py-2 text-gray-600">{{ t.description || '-' }}</td>

            <td class="px-2 py-2 text-right flex justify-end gap-3">
              <!-- Editar -->
              <Link
                :href="route('transactionsEdit', t.id)"
                class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-blue-50 transition"
                title="Editar"
              >
                <Pencil class="w-5 h-5 text-blue-600" />
              </Link>

              <!-- Eliminar -->
              <button
                @click="confirmDelete(t.id)"
                class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-50 transition"
                title="Eliminar"
              >
                <Trash2 class="w-5 h-5 text-red-600" />
              </button>
            </td>
          </tr>

          <tr v-if="props.transactions.length === 0">
            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
              No tienes transacciones registradas aún.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- 🔹 Modal de confirmación -->
    <ConfirmModal
      :show="showModal"
      title="Eliminar transacción"
      message="¿Seguro que deseas eliminar esta transacción? Podras recuperarla desde la papelera"
      @close="showModal = false"
      @confirm="deleteTransaction"
    />
  </DashboardLayout>
</template>
