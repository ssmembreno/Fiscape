<script setup>
import { ref } from 'vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import UserMenu from '@/components/UserMenu.vue';

const props = defineProps({
    accounts: Array,
    categories: Array,
});

const form = useForm({
    name: '',
    account_id: '',
    category_id: '',
    amount: '',
    due_date: '',
    status: 1,
});

const submit = () => {
    form.post(route('upcomingPaysStore'));
};
</script>

<template>
    <DashboardLayout>
        <Head title="Crear Pago Futuro" />

        <!-- Header -->
        <template #header>
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full gap-2 sm:gap-0">
                <nav class="text-sm text-gray-500">
                    <ol class="flex flex-wrap items-center gap-1">
                        <li>
                            <Link :href="route('dashboard')" class="hover:text-[#5046e5]">Inicio</Link>
                        </li>
                        <li>/</li>
                        <li>
                            <Link :href="route('upcomingPaysIndex')" class="hover:text-[#5046e5]">Próximos Pagos</Link>
                        </li>
                        <li>/</li>
                        <li class="text-gray-700 font-medium">Nuevo Próximo Pago</li>
                    </ol>
                </nav>

                <div class="ml-auto">
                    <UserMenu />
                </div>
            </div>
        </template>

        <!-- CARD PRINCIPAL -->
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm p-6 sm:p-10 mt-8 border border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 sm:mb-8">Crear próximo pago</h2>

            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-8">
                <!-- Nombre-->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre / Descripción</label>
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="Ej: Pago de Internet"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#5046e5] focus:border-[#5046e5]"
                        required
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <!-- Cuenta -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cuenta</label>
                    <select
                        v-model="form.account_id"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#5046e5] focus:border-[#5046e5]"
                        required
                    >
                        <option value="">Seleccione una cuenta</option>
                        <option v-for="account in accounts" :key="account.id" :value="account.id">
                            {{ account.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.account_id" class="text-red-500 text-sm mt-1">{{ form.errors.account_id }}</div>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select
                        v-model="form.category_id"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#5046e5] focus:border-[#5046e5]"
                        required
                    >
                        <option value="">Seleccione una categoría</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</div>
                </div>

                <!-- Monto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Monto</label>
                    <input
                        v-model="form.amount"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="Ej: 150.00"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#5046e5] focus:border-[#5046e5]"
                        required
                    />
                    <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">{{ form.errors.amount }}</div>
                </div>

                <!-- Fecha de vencimiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de vencimiento</label>
                    <input
                        v-model="form.due_date"
                        type="date"
                        class="w-full border rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#5046e5] focus:border-[#5046e5]"
                        required
                    />
                    <div v-if="form.errors.due_date" class="text-red-500 text-sm mt-1">{{ form.errors.due_date }}</div>
                </div>

                <!-- Status -->
                <input type="hidden" v-model="form.status"/>

                <!-- BOTONES -->
                <div class="col-span-1 md:col-span-2 flex flex-col sm:flex-row justify-end gap-3 mt-4">
                    <Link
                        :href="route('upcomingPaysIndex')"
                        class="px-5 py-2.5 border rounded-lg text-gray-600 hover:bg-gray-100 transition text-sm font-medium flex items-center justify-center"
                    >
                        Cancelar
                    </Link>

                    <button
                        type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg shadow hover:opacity-90 transition"
                        style="background-color: #5046e5;"
                        :disabled="form.processing"
                    >
                        Guardar Pago
                    </button>
                </div>

            </form>
        </div>
    </DashboardLayout>
</template>
