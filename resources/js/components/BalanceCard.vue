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

const balance = ref(0)
const change = ref(null)

const formatCurrency = (value) => {
  const number = Number(value)
  if (isNaN(number)) return '€0.00'
  return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(number)
}

const fetchBalance = async () => {
  try {
    const response = await api.get('/balance')
    balance.value = response.data.balance
    change.value = response.data.change
    console.log('balance response:', response.data)
  } catch (error) {
    console.error('Error al cargar el balance:', error)
  }
}

onMounted(() => {
  fetchBalance()
})
</script>