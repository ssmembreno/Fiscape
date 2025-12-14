<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import {ref} from 'vue'
import UserMenu from '@/components/UserMenu.vue';
import {Link, Head, useForm} from '@inertiajs/vue3'
import Alerts from '@/components/Alerts.vue';
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const flashMessage = computed(() => page.props.flash?.success || page.props.flash?.error || null)
const flashType = computed(() => page.props.flash?.error ? 'error' : 'success')

const props = defineProps({
    budgets: Object,
    categories: Array
})

function submit(){
    form.post(route('budgetsStore'));
}

const form = useForm({
    amount_limit: '',
    notes: '',
    category_id: '',
})
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
              <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
            </li>
            <li>/</li>
            <li>
              <Link :href="route('categoriesIndex')" class="hover:text-indigo-600">Presupuestos</Link>
            </li>
            <li>/</li>
            <li class="text-gray-700 font-medium">Nuevo Presupuesto</li>
          </ol>
        </nav>
             <div class="ml-auto">
                <UserMenu />
            </div>
      </div>
    </template>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Registrar Presupuesto</h2>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Categoría -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria del presupuesto</label>
            <select v-model="form.category_id"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <option value="">Seleccionar categoría</option>
                <option v-for="cat in props.categories" :key="cat.id" :value="cat.id"> {{ cat.name }} </option>
            </select>                
                <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">
                    {{ form.errors.category_id }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Limite</label>
                <input v-model="form.amount_limit" rows="3" name="amount_limit" id="amount_limit" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Ejemplo: 250.00">
                <div v-if="form.errors.amount_limit" class="text-red-500 text-sm mt-1">
                    {{ form.errors.amount_limit }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Limite</label>
                <textarea v-model="form.notes" rows="3" name="notes" id="notes" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Ejemplo: Presupuesto de alimentación Diciembre"></textarea>
                <div v-if="form.errors.notes" class="text-red-500 text-sm mt-1">
                    {{ form.errors.notes }}
                </div>
            </div>

        <!-- Botones -->
        <div class="flex justify-end gap-2 mt-6">
          <Link :href="route('categoriesIndex')" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100 transition text-sm">
            Cancelar
          </Link>

          <button type="submit" class="px-4 py-2 text-sm font-semibold text-white rounded-md shadow hover:opacity-90 transition"
            style="background-color: #5046e5;" :disabled="form.processing">
            Guardar Presupuesto
          </button>
        </div>
        </form>
    </div>
    

    </DashboardLayout>
</template>