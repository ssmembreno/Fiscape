<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Sidebar from '@/components/Sidebar.vue'
import UserMenu from '@/components/UserMenu.vue'

// ✅ Props reales desde Laravel
const props = defineProps({
    balanceActual: Number,
    totalIngresos: Number,
    totalGastos: Number,
    ahorro: Number,
    transaccionesRecientes: Array,
    budgets: Array,
    upcomingPays: Array,
})

// ✅ Datos estáticos (por ahora)
const upcomingBills = [
    { due: '10 Nov', name: 'Luz', amount: 62.4, status: 'Pendiente' },
    { due: '12 Nov', name: 'Internet', amount: 34.9, status: 'Pendiente' },
    { due: '15 Nov', name: 'Alquiler', amount: 450.0, status: 'Programado' },
    { due: '20 Nov', name: 'Móvil', amount: 10.0, status: 'Pendiente' },
]

// ✅ Función helper
function pct(used, limit) {
    return Math.min(100, Math.round((used / limit) * 100))
}
</script>

<template>
    <Head title="Dashboard • Fiscape" />

    <div class="min-h-screen bg-gray-50">
        <div class="grid grid-cols-12 gap-0">
            <Sidebar class="col-span-12 md:col-span-3 lg:col-span-2" />

            <section class="col-span-12 md:col-span-9 lg:col-span-10">
                <header class="h-16 bg-white border-b px-4 -mt-[1px]">
                    <div class="flex items-center justify-between w-full">
                        <nav class="text-sm text-gray-500">
                            <ol class="flex items-center gap-1">
                                <li>
                                    <Link :href="route('transactionsIndex')" class="hover:text-indigo-600">Transacciones</Link>
                                </li>
                                <li>/</li>
                                <li class="text-gray-700 font-medium">Dashboard</li>
                            </ol>
                        </nav>
                        <div class="ml-auto">
                            <UserMenu />
                        </div>
                    </div>
                </header>

                <div class="p-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="bg-white rounded-xl border p-4">
                            <p class="text-sm text-gray-500">Balance actual</p>
                            <p class="text-2xl font-semibold mt-1">€ {{ balanceActual.toFixed(2) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Actualizado con tus cuentas</p>
                        </div>
                        <div class="bg-white rounded-xl border p-4">
                            <p class="text-sm text-gray-500">Ingresos</p>
                            <p class="text-2xl font-semibold mt-1 text-green-600">€ {{ totalIngresos.toFixed(2) }}</p>
                        </div>
                        <div class="bg-white rounded-xl border p-4">
                            <p class="text-sm text-gray-500">Gastos</p>
                            <p class="text-2xl font-semibold mt-1 text-red-600">€ -{{ totalGastos.toFixed(2) }}</p>
                        </div>
                        <div class="bg-white rounded-xl border p-4">
                            <p class="text-sm text-gray-500">Ahorro neto</p>
                            <p class="text-2xl font-semibold mt-1 text-emerald-600">
                                € {{ balanceActual.toFixed(2) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border">
                        <div class="p-4 flex items-center justify-between">
                            <h4 class="font-semibold">Transacciones recientes</h4>
                            <Link :href="route('transactionsIndex')" class="text-sm px-3 py-1.5 border rounded-md">
                                Ver todas
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 border-y">
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">Categoría</th>
                                        <th class="px-4 py-2">Descripción</th>
                                        <th class="px-4 py-2 text-right">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="t in props.transaccionesRecientes"
                                        :key="t.id"
                                        class="border-b hover:bg-gray-50"
                                    >
                                        <td class="px-4 py-2">{{ t.date }}</td>
                                        <td class="px-4 py-2">{{ t.category?.name || '-' }}</td>
                                        <td class="px-4 py-2">{{ t.description || '-' }}</td>
                                        <td
                                            class="px-4 py-2 text-right font-semibold"
                                            :class="t.type === 1 ? 'text-green-600' : 'text-red-600'"
                                        >
                                            {{ t.type === 1 ? '+' : '-' }}€ {{ parseFloat(t.amount).toFixed(2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

                        <div class="bg-white rounded-xl border">
                            <div class="p-4">
                                <h4 class="font-semibold">Próximos pagos</h4>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-gray-500 border-y">
                                            <th class="px-4 py-2">Concepto</th>
                                            <th class="px-4 py-2">Fecha</th>
                                            <th class="px-4 py-2 text-right">Importe</th>
                                            <th class="px-4 py-2 text-right">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="b in upcomingPays"
                                            :key="b.name"
                                            class="border-b hover:bg-gray-50"
                                        >
                                            <td class="px-4 py-2">{{ b.name }}</td>
                                            <td class="px-4 py-2">{{ b.due_date }}</td>
                                            <td class="px-4 py-2 text-right font-semibold">€ {{ parseFloat(b.amount).toFixed(2) }}</td>
                                            <td class="px-4 py-2 text-right font-semibold text-red-600" v-if="b.status === 1">Pendiente</td>
                                            <td class="px-4 py-2 text-right font-semibold text-green-600" v-if="b.status === 0">Pagado</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border p-4">
                            <h4 class="font-semibold mb-2">Presupuestos</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div v-for="b in budgets" :key="b.id" class="p-3 border rounded-lg">
                                    <p class="text-sm text-gray-600">{{ b.category.name }}</p>
                                    <div class="mt-2 w-full bg-gray-100 h-2 rounded">
                                        <div
                                            class="h-2 bg-indigo-600 rounded"
                                            :style="`width:${pct(b.amount_spent, b.amount_limit)}%`"
                                        ></div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ pct(b.amount_spent, b.amount_limit) }}% usado</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</template>