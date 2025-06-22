<template>
  <div>
    <h2>Registro</h2>
    <form @submit.prevent="register">
      <input v-model="form.name" type="text" placeholder="Nombre" required>
      <input v-model="form.email" type="email" placeholder="Email" required>
      <input v-model="form.password" type="password" placeholder="Contraseña" required>
      <input v-model="form.password_confirmation" type="password" placeholder="Confirmar contraseña" required>

      <button type="submit">Registrarse</button>
    </form>

    <p v-if="error" style="color:red">{{ error }}</p>
    <p v-if="success" style="color:green">{{ success }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      error: null,
      success: null,
    }
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('/api/register', this.form)
        this.success = response.data.message
        this.error = null
      } catch (err) {
        console.log(err.response)
        this.success = null
        if (err.response && err.response.data.errors) {
          this.error = Object.values(err.response.data.errors).flat()[0]
        } else {
          this.error = 'Ocurrió un error al registrar.'
        }
      }
    }
  }
}
</script>
