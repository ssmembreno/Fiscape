<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import UserMenu from '@/components/UserMenu.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import ConfirmModal from '@/components/ConfirmModal.vue'

const props = defineProps({
    budgets: Array,
})

// PARA EL MODAL
const showConfirmModal = ref(false)
const selectedBudgetId = ref(null)

// PARA EL MENU DE 3 PUNTOS
const openMenuId = ref(null)

const toggleMenu = (id) => {
    openMenuId.value = openMenuId.value === id ? null : id
}

const openConfirmModal = (id) => {
    selectedBudgetId.value = id
    showConfirmModal.value = true
}

const confirmDelete = () => {
    router.delete(route('budgetsDestroy', selectedBudgetId.value), {
        onFinish: () => {
            showConfirmModal.value = false
        }
    })
}

const resetBudget = (id) => {
    router.get(route('budgetsReset', id), {
        onFinish: () => {
            openMenuId.value = null
        }
    })
}

const resetAllBudgets = () => {
    router.get(route('budgetsResetAll'), {
        onFinish: () => {
            openMenuId.value = null
        }
    })
}

const getPercent = (spent, limit) => {
    if (limit === 0) return 0
    return Math.min((spent / limit) * 100, 100)
}
</script>

<template>
    <Head title="Presupuestos" />

    <DashboardLayout>

        <!--Header -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <nav class="text-sm text-gray-500">
                <ol class="flex items-center gap-1">
                    <li>
                    <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
                    </li>
                    <li>/</li>
                    <li class="text-gray-700 font-medium">Presupuestos</li>
                </ol>
                </nav>
                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>

        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Mis Presupuestos</h3>

            <Link :href="route('budgetsCreate')"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
                style="background-color: #5046e5;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Presupuesto
            </Link>
        </div>
        <!-- GRID -->
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div v-for="b in budgets" :key="b.id"
                        class="relative bg-white shadow rounded-xl p-5 border border-gray-100">

                        <div class="flex items-center justify-between mb-1">
                            <!-- TITULO -->
                            <p class="text-lg font-semibold text-gray-700">
                                {{ b.category?.name }}
                            </p>

                            <div class="flex items-center gap-2">
                                <!-- Restablecer Presupuesto Button -->
                                <button @click="resetBudget(b.id); openMenuId = null"
                                    class="p-1 hover:bg-gray-100 rounded-full text-gray-600" title="Restablecer Presupuesto">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" class="h-5 w-5">
                                        <path d="M18 28A12 12 0 1 0 6 16v6.2l-3.6-3.6L1 20l6 6l6-6l-1.4-1.4L8 22.2V16a10 10 0 1 1 10 10z" fill="currentColor"></path>
                                    </svg>
                                </button>

                                <!-- MENU (3 puntos) -->
                                <div class="relative">
                                    <button @click="toggleMenu(b.id)" class="p-1 hover:bg-gray-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <!-- DROPDOWN -->
                                    <div v-if="openMenuId === b.id"
                                        class="absolute right-0 mt-1 w-32 bg-white border rounded-lg shadow-md z-20">

                                        <Link :href="route('budgetsEdit', b.id)"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100">
                                            Editar
                                        </Link>

                                        <button @click="openConfirmModal(b.id); openMenuId = null"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500">Límite mensual asignado</p>

                        <!-- VALORES -->
                        <div class="flex justify-between text-sm mt-3 mb-1">
                            <span class="text-gray-600" v-if="b.amount_spent > b.amount_limit">Gastado: <span class="text-red-600">€{{ b.amount_spent }}</span></span>
                            <span class="text-gray-600" v-else>Gastado: <span class="text-green-600">€{{ b.amount_spent }}</span></span>
                            <span class="text-gray-600">Límite: €{{ b.amount_limit }}</span>
                        </div>

                        <!-- PORCENTAJE -->
                        <p class="text-right text-xs font-medium text-gray-500 mb-1">
                            {{ getPercent(b.amount_spent, b.amount_limit).toFixed(0) }}%
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-300"
                                :class="{
                                    'bg-red-500': Number(b.amount_spent) > Number(b.amount_limit),
                                    'bg-green-500': Number(b.amount_spent) <= Number(b.amount_limit)
                                }"
                                :style="{ width: getPercent(b.amount_spent, b.amount_limit) + '%' }">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL ELIMINAR -->
        <ConfirmModal 
            :show="showConfirmModal"
            title="Eliminar Presupuesto"
            message="¿Estás seguro que deseas eliminar este presupuesto?"
            @close="showConfirmModal = false"
            @confirm="confirmDelete"
        />

    </DashboardLayout>
</template>
