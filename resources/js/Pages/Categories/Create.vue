<script setup>
import {ref} from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Alerts from '@/components/Alerts.vue';
import UserMenu from '@/components/UserMenu.vue';

const form = useForm({
    name: '',
    descripcion: '',
})

function submit(){
    form.post(route('categoriesStore'))
}

</script>

<template>
    <Head tittle="Nueva Categoria"></Head>

    <DashboardLayout>
    <Alerts  v-if="flashMessage" :message="flashMessage" :type="flashType"/>
    <template #header>
      <div class="flex items-center justify-between w-full">
        <nav class="text-sm text-gray-500">
          <ol class="flex items-center gap-1">
            <li>
              <Link :href="route('categoriesIndex')" class="hover:text-indigo-600">Categorias</Link>
            </li>
            <li>/</li>
            <li class="text-gray-700 font-medium">Nueva Categoria</li>
          </ol>
        </nav>
             <div class="ml-auto">
                <UserMenu />
            </div>
      </div>
    </template>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Registrar Categoria</h2>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Categoría -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la categoria</label>
                <input v-model="form.name" type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                    {{ form.errors.name }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea v-model="form.descripcion" rows="3" name="descripcion" id="descripcion" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Ejemplo: Bebidas del mes (Cocacolas, Shakes, RedBulls. etc)"></textarea>
                <div v-if="form.errors.descripcion" class="text-red-500 text-sm mt-1">
                    {{ form.errors.descripcion }}
                </div>
            </div>

        <!-- Botones -->
        <div class="flex justify-end gap-2 mt-6">
          <Link :href="route('categoriesIndex')" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100 transition text-sm">
            Cancelar
          </Link>

          <button type="submit" class="px-4 py-2 text-sm font-semibold text-white rounded-md shadow hover:opacity-90 transition"
            style="background-color: #a3e635;" :disabled="form.processing">
            Guardar Transacción
          </button>
        </div>
        </form>
    </div>
    

    </DashboardLayout>
</template>