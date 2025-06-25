import api from '@/axios'

export async function initCsrf() {
  await api.get('/sanctum/csrf-cookie')
}