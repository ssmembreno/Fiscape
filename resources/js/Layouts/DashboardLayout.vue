<script setup>
import Sidebar from '@/components/Sidebar.vue'
</script>

<template>
  <!-- Grid general: sidebar + contenido -->
  <div class="min-h-screen bg-gray-50 lg:grid lg:grid-cols-[260px_1fr]">
    <!-- Sidebar -->
    <Sidebar />

    <!-- Contenido principal -->
    <div class="flex flex-col min-h-screen">
      <!-- Topbar -->
      <header
        class="h-16 bg-white border-b flex items-center justify-between px-6 sticky top-0 z-30 shadow-sm"
      >
        <slot name="header" />
      </header>

      <!-- Contenedor del contenido -->
      <main class="flex-1 p-6 max-w-7xl mx-auto w-full">
        <slot />
      </main>
    </div>
  </div>
</template>
