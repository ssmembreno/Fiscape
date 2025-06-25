<!-- resources/js/components/AddIncome.vue -->
<template>
  <form @submit.prevent="submitTransaction">
    <input v-model="form.amount" type="number" step="0.01" placeholder="Cantidad" required />
    <input v-model="form.description" type="text" placeholder="Descripción" />
    <input v-model="form.transaction_date" type="date" required />
    <select v-model="form.category_id" required>
      <option disabled value="">Selecciona una categoría</option>
      <option v-for="category in categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>
    <button type="submit">Añadir ingreso</button>
  </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/axios'

const form = ref({
  amount: '',
  description: '',
  transaction_date: '',
  category_id: ''
})

const categories = ref([])

const submitTransaction = async () => {
  try {
    await api.post('/transactions', form.value)
    alert('Ingreso añadido correctamente')
    // aquí podrías emitir un evento o limpiar el form
  } catch (error) {
    alert('Error al guardar: ' + error.response.data.message)
  }
}


const fetchCategories = async () => {
  try {
    const res = await api.get('/categories') 
    categories.value = res.data
    console.log('categorías cargadas:', res.data)
  } catch (err) {
    console.error('Error cargando categorías', err)
  }
}

onMounted(() => {
  fetchCategories()
})
</script>
