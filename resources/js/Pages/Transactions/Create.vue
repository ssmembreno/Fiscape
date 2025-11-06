<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Alerts from '@/components/Alerts.vue'

const props = defineProps({
  categories: Array,
})

// Inicializamos el formulario
const form = useForm({
  category_id: '',
  type: '1',
  amount: '',
  date: '',
  description: '',
})

function submit() {
  form.post(route('transactions.store'))
}
</script>

<template>
  <Head title="Nueva Transacción" />

  <DashboardLayout>
    <Alerts 
      v-if="flashMessage"
      :message="flashMessage"
      :type="flashType"
    />
    <template #header>
      <div class="flex items-center justify-between w-full">
        <nav class="text-sm text-gray-500">
          <ol class="flex items-center gap-1">
            <li>
              <Link :href="route('transactionsIndex')" class="hover:text-indigo-600">Transacciones</Link>
            </li>
            <li>/</li>
            <li class="text-gray-700 font-medium">Nueva Transacción</li>
          </ol>
        </nav>
      </div>
    </template>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Registrar Transacción</h2>

      <form @submit.prevent="submit" class="space-y-5">
        <!-- Categoría -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
          <select
            v-model="form.category_id"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          >
            <option value="">Seleccionar categoría</option>
            <option
              v-for="cat in props.categories"
              :key="cat.id"
              :value="cat.id"
            >
              {{ cat.name }}
            </option>
          </select>
          <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">
            {{ form.errors.category_id }}
          </div>
        </div>

        <!-- Tipo -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
          <div class="flex gap-4">
            <label class="flex items-center gap-2">
              <input type="radio" value="1" v-model="form.type" />
              <span>Ingreso</span>
            </label>
            <label class="flex items-center gap-2">
              <input type="radio" value="2" v-model="form.type" />
              <span>Gasto</span>
            </label>
          </div>
          <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">
            {{ form.errors.type }}
          </div>
        </div>

        <!-- Monto -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Monto (€)</label>
          <input
            type="number"
            step="0.01"
            v-model="form.amount"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          />
          <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">
            {{ form.errors.amount }}
          </div>
        </div>

        <!-- Fecha -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
          <input
            type="date"
            v-model="form.date"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          />
          <div v-if="form.errors.date" class="text-red-500 text-sm mt-1">
            {{ form.errors.date }}
          </div>
        </div>

        <!-- Descripción -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
          <textarea
            v-model="form.description"
            rows="3"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm resize-none"
            placeholder="Ej: Pago de luz, compra supermercado, etc."
          ></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
            {{ form.errors.description }}
          </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-2 mt-6">
          <Link
            :href="route('transactionsIndex')"
            class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100 transition text-sm"
          >
            Cancelar
          </Link>

          <button
            type="submit"
            class="px-4 py-2 text-sm font-semibold text-white rounded-md shadow hover:opacity-90 transition"
            style="background-color: #a3e635;"
            :disabled="form.processing"
          >
            Guardar Transacción
          </button>
        </div>
      </form>
    </div>
  </DashboardLayout>
</template>
