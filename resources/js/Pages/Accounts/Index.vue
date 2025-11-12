<script setup>
import { Head, Link, router} from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import UserMenu from '@/components/UserMenu.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import Alerts from '@/components/Alerts.vue';
import { Pencil , Trash2} from 'lucide-vue-next';
import {ref} from 'vue'


const props = defineProps({
    accounts: Object,
})

const typeMap = {
    bank: 'Banco',
    cash: 'Efectivo',
    digital: 'Digital',
    credit_card: 'Tarjeta de credito',
    debit_card: 'Tarjeta de debito',
    crypto: 'Criptomonedas',
    other: 'Otro'
};

// Estado del modal y transacción seleccionada
const showModal = ref(false)
const accountsToDelete = ref(null)

// Abrir modal de confirmación
const confirmDelete = (id) => {
  accountsToDelete.value = id
  showModal.value = true
}

// Eliminar transacción
const accountsDelete = () => {
  if (!accountsToDelete.value) return
  router.delete(route('accountsDestroy', accountsToDelete.value), {
    onFinish: () => {
      showModal.value = false
      accountsToDelete.value = null
    },
  })
}
</script>

<template>
    <DashboardLayout>
      <Head title="Cuentas"></Head>  
      <!--Header -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <nav class="text-sm text-gray-500">
                <ol class="flex items-center gap-1">
                    <li>
                    <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
                    </li>
                    <li>/</li>
                    <li class="text-gray-700 font-medium">Cuentas</li>
                </ol>
                </nav>
                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>

        <!-- Tabla Cuentas -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Cuentas</h3>
                <div>
                    <Link :href="route('accountsCreate')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
                            style="background-color: #84cc16;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Cuenta
                    </Link>
                </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mt-4 overflow-x-auto">
           
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Balance</th>
                    <th class="px-4 py-3">Divisa</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="acc in props.accounts" :key="acc.id" class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ acc.name || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ typeMap[acc.type] || acc.type || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ acc.balance || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ acc.currency || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ acc.description || '-' }}</td>
                    <td class="px-2 py-2 text-center flex gap-3">
                        <Link :href="route('accountsEdit', acc.id)" class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-blue-50 transition" title="Editar">
                            <Pencil class="w-5 h-5 text-blue-600" />
                        </Link>
                        <button @click="confirmDelete(acc.id)" class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-50 transition" title="Eliminar">
                            <Trash2 class="w-5 h-5 text-red-600"/>
                        </button>
                    </td>
                </tr>
                    <tr v-if="props.accounts.length === 0">
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No tienes cuentas registradas aún.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayout>

    <ConfirmModal
      :show="showModal"
      title="Eliminar Cuenta"
      message="¿Seguro que deseas eliminar esta cuenta?"
      @close="showModal = false"
      @confirm="accountsDelete"
    />
</template>