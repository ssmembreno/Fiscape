<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import UserMenu from '@/components/UserMenu.vue';
import Alerts from '@/components/Alerts.vue';

const props = defineProps({
    accounts: Object,
})

const form = useForm({
  name: props.accounts.name || '',
  description: props.accounts.description || '',
  type: props.accounts.type || '',
  currency: props.accounts.currency || 'EUR',
  balance: props.accounts.balance || '',
});

const submit = () =>
  form.put(route('accountsUpdate', props.accounts.id), {
    preserveScroll: true,
    onSuccess: () => console.log('Cuenta actualizada correctamente'),
    onError: (errors) => console.error(errors),
  });
</script>

<template>
  <DashboardLayout>
    <Head title="Editar Cuenta" />

    <!-- Alertas -->
    <Alerts v-if="flashMessage" :message="flashMessage" :type="flashType" />

    <!-- Header -->
    <template #header>
      <div class="flex items-center justify-between w-full">
        <nav class="text-sm text-gray-500">
          <ol class="flex items-center gap-1">
            <li>
              <Link :href="route('accountsIndex')" class="hover:text-indigo-600">Cuentas</Link>
            </li>
            <li>/</li>
            <li class="text-gray-700 font-medium">Editar Cuenta</li>
          </ol>
        </nav>
        <div class="ml-auto">
          <UserMenu />
        </div>
      </div>
    </template>

    <!-- Card principal -->
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm p-10 mt-8 border border-gray-100">
      <h2 class="text-2xl font-semibold text-gray-800 mb-8">Modificar cuenta</h2>

      <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Nombre -->
        <div class="col-span-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la cuenta</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="Ej: Cuenta BBVA, PayPal, Efectivo"
            class="w-full border rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          />
          <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <!-- Tipo -->
        <div class="col-span-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
          <select
            v-model="form.type"
            class="w-full border rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          >
            <option disabled value="">Selecciona tipo</option>
            <option value="bank">Banco</option>
            <option value="cash">Efectivo</option>
            <option value="digital">Digital (PayPal, Revolut...)</option>
            <option value="credit_card">Tarjeta crédito</option>
            <option value="debit_card">Tarjeta débito</option>
            <option value="crypto">Criptomonedas</option>
            <option value="other">Otro</option>
          </select>
          <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">{{ form.errors.type }}</div>
        </div>

        <!-- Balance -->
        <div class="col-span-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">Balance</label>
          <input
            v-model="form.balance"
            type="number"
            min="0"
            step="0.01"
            placeholder="Ej: 1800.00"
            class="w-full border rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          />
          <div v-if="form.errors.balance" class="text-red-500 text-sm mt-1">{{ form.errors.balance }}</div>
        </div>

        <!-- Divisa -->
        <div class="col-span-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">Divisa</label>
          <select
            v-model="form.currency"
            class="w-full border rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          >
            <option value="EUR">Euro (EUR)</option>
            <option value="USD">Dólar (USD)</option>
            <option value="GBP">Libra esterlina (GBP)</option>
            <option value="HNL">Lempira (HNL)</option>
          </select>
          <div v-if="form.errors.currency" class="text-red-500 text-sm mt-1">{{ form.errors.currency }}</div>
        </div>

        <!-- Descripción -->
        <div class="col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
          <textarea
            v-model="form.description"
            rows="4"
            placeholder="Ej: Cuenta personal o cuenta de ahorros."
            class="w-full border rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
          ></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
        </div>

        <!-- Botones -->
        <div class="col-span-2 flex justify-end gap-3 mt-4">
          <Link
            :href="route('accountsIndex')"
            class="px-5 py-2.5 border rounded-lg text-gray-600 hover:bg-gray-100 transition text-sm font-medium"
          >
            Cancelar
          </Link>
          <button
            type="submit"
            class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg shadow hover:opacity-90 transition"
            style="background-color: #84cc16;"
            :disabled="form.processing"
          >
            Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </DashboardLayout>
</template>
