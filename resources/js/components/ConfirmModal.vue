<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  show: Boolean,
  title: {
    type: String,
    default: '¿Estás seguro?',
  },
  message: {
    type: String,
    default: 'Esta acción no se puede deshacer.',
  },
})

const emit = defineEmits(['confirm', 'close'])

const visible = ref(props.show)
watch(() => props.show, (v) => (visible.value = v))
</script>

<template>
  <transition name="fade">
    <div
      v-if="visible"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
    >
      <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 space-y-4">
        <h3 class="text-lg font-semibold text-gray-800">{{ props.title }}</h3>
        <p class="text-sm text-gray-600">{{ props.message }}</p>

        <div class="flex justify-end gap-3 mt-6">
          <button
            @click="$emit('close')"
            class="px-4 py-2 border rounded-md text-sm text-gray-700 hover:bg-gray-100 transition"
          >
            Cancelar
          </button>
          <button
            @click="$emit('confirm')"
            class="px-4 py-2 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
            style="background-color: #ef4444;"
          >
            Eliminar
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
