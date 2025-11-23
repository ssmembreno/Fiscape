<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import UserMenu from '@/components/UserMenu.vue'

// Props recibidas desde el controlador
const props = defineProps({
    budget: Object,
    categories: Array,
})

// Formulario inicial con los datos del presupuesto
const form = useForm({
    category_id: props.budget.category_id,
    amount_limit: props.budget.amount_limit,
    notes: props.budget.notes ?? '',
})

// Enviar formulario
const submit = () => {
    form.put(route('budgetsUpdate', props.budget.id), {
        preserveScroll: true,
        onSuccess: () => console.log("✅ Presupuesto actualizado"),
        onError: (e) => console.error(e),
    })
}
</script>

<template>
    <Head title="Editar Presupuesto" />

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
                    <li><Link :href="route('budgetsIndex') " class="hover:text-indigo-600">Presupuestos</Link></li>
                    <li>/</li>
                    <li class="text-gray-700 font-medium">Editar Presupuesto</li>
                </ol>
                </nav>
                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-md rounded-lg p-6">

                    <!-- Formulario -->
                    <form @submit.prevent="submit">

                        <!-- Categoría -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Categoría</label>
                            <select v-model="form.category_id" class="w-full border-gray-300 rounded-lg">
                                <option value="">Selecciona una categoría</option>
                                <option v-for="cat in props.categories" :key="cat.id" :value="cat.id">
                                    {{ cat.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">
                                {{ form.errors.category_id }}
                            </div>
                        </div>

                        <!-- Límite -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Límite de gasto</label>
                            <input
                                type="number"
                                v-model="form.amount_limit"
                                min="0"
                                class="w-full border-gray-300 rounded-lg"
                            />
                            <div v-if="form.errors.amount_limit" class="text-red-500 text-sm mt-1">
                                {{ form.errors.amount_limit }}
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Notas</label>
                            <textarea
                                v-model="form.notes"
                                rows="3"
                                class="w-full border-gray-300 rounded-lg"
                            ></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end mt-6">
                            <Link
                                :href="route('budgetsIndex')"
                                class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 mr-3"
                            >
                                Cancelar
                            </Link>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                :disabled="form.processing"
                            >
                                Guardar cambios
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
