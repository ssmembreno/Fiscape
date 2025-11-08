<script setup>
import {ref} from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import UserMenu from '@/components/UserMenu.vue';
import { Head, Link, router } from '@inertiajs/vue3'
import { Pencil, Trash2} from 'lucide-vue-next';
import ConfirmModal from '@/components/ConfirmModal.vue';

const props = defineProps({
    categories :  Array,
    categoriesUsers: Array
})

// Estado del modal y transacción seleccionada
const showModal = ref(false)
const categoriesToDelete = ref(null)

// Abrir modal de confirmación
const confirmDelete = (id) => {
  categoriesToDelete.value = id
  showModal.value = true
}

// Eliminar transacción
const deletecategories = () => {
  if (!categoriesToDelete.value) return
  router.delete(route('categoriesDestroy', categoriesToDelete.value), {
    onFinish: () => {
      showModal.value = false
      categoriesToDelete.value = null
    },
  })
}
</script>

<template>
    <DashboardLayout>
        <Head title="Categorias"></Head>
        <!--Header -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <nav class="text-sm text-gray-500">
                <ol class="flex items-center gap-1">
                    <li>
                    <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
                    </li>
                    <li>/</li>
                    <li class="text-gray-700 font-medium">Categorias</li>
                </ol>
                </nav>
                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>
        <!-- Tabla categorias usuario -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Mis Categorias</h3>
                <div>
                    <Link :href="route('categoriesCreate')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
                            style="background-color: #84cc16;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Categoria
                    </Link>
                </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mt-4 overflow-x-auto">
           
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3 text-left">Descripcion</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="catUsers in props.categoriesUsers" :key="catUsers.id" class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ catUsers.name || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ catUsers.descripcion || '-' }}</td>
                    <td class="px-2 py-2 text-center flex gap-3">
                        <Link :href="route('categoriesEdit', catUsers.id)" class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-blue-50 transition" title="Editar">
                            <Pencil class="w-5 h-5 text-blue-600" />
                        </Link>
                        <button @click="confirmDelete(catUsers.id)" class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-50 transition" title="Eliminar">
                            <Trash2 class="w-5 h-5 text-red-600"/>
                        </button>
                    </td>
                </tr>
                 <tr v-if="props.categoriesUsers.length === 0">
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        No tienes Categorias propias registradas aún.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla -->
        <h3 class="mt-10 text-lg font-medium">Categorias Predefinidas</h3> 
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mt-4 overflow-x-auto">
            
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3 text-left">Descripcion</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="c in props.categories" :key="c.id" class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ c.name || '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ c.descripcion || '-' }}</td>
                </tr>
                <tr v-if="props.categories.length === 0">
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        No tienes Categorias registradas aún.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


    <!-- 🔹 Modal de confirmación -->
    <ConfirmModal
      :show="showModal"
      title="Eliminar transacción"
      message="¿Seguro que deseas eliminar esta categoria?"
      @close="showModal = false"
      @confirm="deletecategories"
    />
    </DashboardLayout>
</template>