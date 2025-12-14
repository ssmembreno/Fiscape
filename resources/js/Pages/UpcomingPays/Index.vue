<script setup>
import { ref } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import UserMenu from '@/components/UserMenu.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    upcomingPays: Array,
})
</script>

<template>
    <Head title="Próximos Pagos" />

    <DashboardLayout>
        <!-- Header -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <!-- Breadcrumb -->
                <nav class="text-sm text-gray-500">
                    <ol class="flex items-center gap-1">
                        <li>
                            <Link :href="route('dashboard')" class="hover:text-indigo-600">Inicio</Link>
                        </li>
                        <li>/</li>
                        <li class="text-gray-700 font-medium">Próximos pagos</li>
                    </ol>
                </nav>

                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>

        <!-- Barra de herramientas -->
        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <!-- Buscador -->
                <div class="relative w-full sm:w-64">
                    <input
                        type="text"
                        placeholder="Buscar pagos..."
                        class="w-full pl-10 pr-4 py-2 border rounded-md text-sm focus:ring-2
                               focus:ring-[#5046e5] focus:border-[#5046e5] outline-none"
                    />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-3 top-2.5 h-4 w-4 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z"
                        />
                    </svg>
                </div>
            </div>

            <Link
                :href="route('upcomingPaysCreate')"
                class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-white rounded-md shadow hover:opacity-90 transition"
                style="background-color: #5046e5;"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Proximo Pago
            </Link>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mt-4 overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-600 uppercase text-xs">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Cuenta</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="t in props.upcomingPays"
                        :key="t.id"
                        class="border-b hover:bg-gray-50 transition"
                    >
                        <td class="px-4 py-2">{{ t.due_date }}</td>
                        <td class="px-4 py-2">{{ t.account?.name }}</td>
                        <td class="px-4 py-2">{{ t.amount }}</td>
                        <td class="px-4 py-2">{{ t.category?.name }}</td>
                        <td class="px-4 py-2 text-red-500" v-if="t.status == 1">Pendiente</td>
                        <td class="px-4 py-2 text-green-500" v-if="t.status == 0">Pagado</td>

                        <td class="px-2 py-2 text-right flex justify-end gap-3">
                            <!-- Listo para cuando actives edición y delete -->
                        </td>
                    </tr>

                    <tr v-if="props.upcomingPays.length === 0">
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No tienes pagos futuros registrados aún.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayout>
</template>
