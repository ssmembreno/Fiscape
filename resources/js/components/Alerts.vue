<script setup>
import { ref, watchEffect } from 'vue'

// Props: mensaje, tipo y duración
const props = defineProps({
  message: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'success', // success | error | warning | info
  },
  duration: {
    type: Number,
    default: 4000, // tiempo de auto cierre (ms)
  },
})

const visible = ref(true)

watchEffect(() => {
  if (visible.value && props.duration > 0) {
    setTimeout(() => (visible.value = false), props.duration)
  }
})

const bgColors = {
  success: 'bg-green-100 text-green-800 border-green-300',
  error: 'bg-red-100 text-red-800 border-red-300',
  warning: 'bg-yellow-100 text-yellow-800 border-yellow-300',
  info: 'bg-blue-100 text-blue-800 border-blue-300',
}
</script>

<template>
  <transition name="fade">
    <div
      v-if="visible"
      :class="['fixed top-5 right-5 z-50 border px-4 py-3 rounded-lg shadow-sm w-80 flex items-center justify-between', bgColors[type]]"
      role="alert"
    >
      <span class="text-sm font-medium">{{ message }}</span>
      <button @click="visible = false" class="ml-3 text-lg leading-none">&times;</button>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
