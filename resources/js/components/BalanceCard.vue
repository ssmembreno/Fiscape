<template>
  <div class="bg-white p-5 rounded-xl shadow-md w-full max-w-xs">
    <div class="flex justify-between items-start">
      <div>
        <p class="text-gray-500 text-sm font-medium">Balance actual</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-1">
          {{ formatCurrency(balance) }}
        </h2>
        <p v-if="change !== null" :class="['text-sm font-semibold mt-1', change >= 0 ? 'text-green-600' : 'text-red-600']">
          {{ change >= 0 ? '+' : '' }}{{ change.toFixed(2) }}%
        </p>
      </div>
      <div class="bg-gray-100 p-2 rounded-full">
        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 1.343-3 3v1a3 3 0 003 3v3m0-6h3m-3-6v3m6 4a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/axios'
import {initCsrf} from '@/utils/csrf'

// Balance actual
const balance = ref(0)
const change = ref(null)

const fetchBalance = async () => {
  try {
    const res = await api.get('/balance')
    balance.value = res.data.balance
    change.value = res.data.change ?? null
  } catch (error) {
    console.error('Error al cargar balance', error)
  }
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('es-ES', {
    style: 'currency',
    currency: 'EUR'
  }).format(amount)
}

onMounted(async() => {
  await initCsrf();
  fetchBalance()
})
</script>
