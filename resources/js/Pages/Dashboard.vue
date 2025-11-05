<script setup>
import { Head, Link } from '@inertiajs/vue3'

// Datos dummy para render
const kpis = [
  { label: 'Balance actual', value: '€ 5.420', sub: '+€320 este mes' },
  { label: 'Ingresos (mes)', value: '€ 2.750', sub: '+4.2% vs. ant.' },
  { label: 'Gastos (mes)', value: '€ 2.430', sub: '-3.1% vs. ant.' },
  { label: 'Ahorro (mes)', value: '€ 320', sub: 'Tasa de ahorro 11.6%' },
]

const recentTx = [
  { date: '05 Nov', desc: 'Supermercado', cat: 'Alimentación', amount: -46.20, account: 'Débito BBVA' },
  { date: '05 Nov', desc: 'Nómina', cat: 'Ingresos', amount: 1250.00, account: 'BBVA Nómina' },
  { date: '04 Nov', desc: 'Netflix', cat: 'Suscripciones', amount: -12.99, account: 'Visa' },
  { date: '04 Nov', desc: 'Café', cat: 'Ocio', amount: -2.10, account: 'Visa' },
  { date: '03 Nov', desc: 'Gasolina', cat: 'Transporte', amount: -35.50, account: 'Visa' },
]

const upcomingBills = [
  { due: '10 Nov', name: 'Luz', amount: 62.40, status: 'Pendiente' },
  { due: '12 Nov', name: 'Internet', amount: 34.90, status: 'Pendiente' },
  { due: '15 Nov', name: 'Alquiler', amount: 450.00, status: 'Programado' },
  { due: '20 Nov', name: 'Móvil', amount: 10.00, status: 'Pendiente' },
]

const budgets = [
  { cat: 'Alimentación', used: 180, limit: 250 },
  { cat: 'Transporte', used: 90, limit: 120 },
  { cat: 'Ocio', used: 75, limit: 150 },
  { cat: 'Suscripciones', used: 25, limit: 40 },
]

function pct(used, limit) {
  return Math.min(100, Math.round((used / limit) * 100))
}
</script>

<template>
  <Head title="Dashboard • Fiscape" />

  <div class="min-h-screen bg-gray-50">
    <!-- Layout principal: sidebar + contenido -->
    <div class="grid grid-cols-12 gap-0">
      <!-- Sidebar -->
      <aside class="col-span-12 md:col-span-3 lg:col-span-2 border-r bg-white">
        <div class="h-16 flex items-center px-4 border-b">
          <div class="inline-flex items-center gap-2">
            <div class="h-8 w-8 rounded-xl bg-indigo-600"></div>
            <span class="font-semibold">Fiscape</span>
          </div>
        </div>

        <nav class="p-4 space-y-6 text-sm">
          <!-- Módulos principales -->
          <div>
            <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Main</p>
            <ul class="space-y-1">
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md bg-gray-100 font-medium">🏠 Dashboard</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🧾 Transacciones</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🏦 Cuentas &amp; Tarjetas</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">📊 Reportes</a></li>
            </ul>
          </div>

          <!-- Gestión -->
          <div>
            <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Gestión</p>
            <ul class="space-y-1">
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🏷️ Categorías</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🔁 Recurrentes</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🎯 Presupuestos</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">📅 Facturas &amp; Recibos</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">💰 Metas de Ahorro</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">📈 Inversiones</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">💳 Deudas &amp; Préstamos</a></li>
            </ul>
          </div>

          <!-- Utilidades -->
          <div>
            <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Utilidades</p>
            <ul class="space-y-1">
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">⬆️ Importar</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">⬇️ Exportar</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🔔 Recordatorios</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🔗 Integraciones</a></li>
            </ul>
          </div>

          <!-- Administración -->
          <div>
            <p class="px-2 mb-2 text-gray-500 uppercase tracking-wider text-xs">Administración</p>
            <ul class="space-y-1">
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">👤 Usuarios</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">⚙️ Ajustes</a></li>
              <li><a class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">🧾 Auditoría</a></li>
            </ul>
          </div>
        </nav>
      </aside>

      <!-- Contenido -->
      <section class="col-span-12 md:col-span-9 lg:col-span-10">
        <!-- Topbar -->
        <div class="h-16 bg-white border-b flex items-center justify-between px-4">
          <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
            <span>Home</span>
            <span>/</span>
            <span class="text-gray-900 font-medium">Dashboard</span>
          </div>

          <div class="flex items-center gap-2">
            <input type="text" placeholder="Buscar…" class="hidden md:block px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            <button class="px-3 py-2 border rounded-md text-sm">Rango: 5 Nov – 25 Nov</button>
            <button class="px-3 py-2 border rounded-md text-sm">Crear</button>
            <button class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">Exportar</button>
          </div>
        </div>

        <!-- Contenido scroll -->
        <div class="p-4 space-y-6">
          <!-- Bienvenida -->
          <div class="bg-indigo-600 text-white rounded-xl p-6 flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold">¡Buenos días!</h3>
              <p class="text-sm opacity-90">Tienes 4 facturas por vencer esta semana.</p>
              <div class="mt-2 text-xs opacity-80">Miércoles, 05 Nov 2025 • 11:24 AM</div>
            </div>
            <img src="/assets/img/events/speaker-8.webp" alt="" class="hidden md:block h-20 rounded-lg opacity-90">
          </div>

          <!-- KPIs -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div v-for="(k, i) in kpis" :key="i" class="bg-white rounded-xl border p-4">
              <p class="text-sm text-gray-500">{{ k.label }}</p>
              <p class="text-2xl font-semibold mt-1">{{ k.value }}</p>
              <p class="text-xs text-gray-500 mt-1">{{ k.sub }}</p>
            </div>
          </div>

          <!-- Tarjetas analíticas -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Resumen de ventas/ingresos -->
            <div class="bg-white rounded-xl border p-4">
              <h4 class="font-semibold">Flujo de caja (30 días)</h4>
              <p class="text-xs text-gray-500">Ingresos vs. Gastos</p>
              <!-- Placeholder de gráfico (SVG) -->
              <div class="mt-4 h-36 w-full">
                <svg viewBox="0 0 100 40" class="w-full h-full">
                  <polyline fill="none" stroke="#4f46e5" stroke-width="2"
                    points="0,30 10,25 20,28 30,20 40,15 50,18 60,12 70,16 80,10 90,14 100,8" />
                  <polyline fill="none" stroke="#ef4444" stroke-width="2"
                    points="0,35 10,30 20,32 30,28 40,25 50,27 60,23 70,26 80,22 90,24 100,20" />
                </svg>
              </div>
              <div class="mt-3 flex items-center gap-3 text-sm">
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-indigo-600"></span> Ingresos</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-red-500"></span> Gastos</span>
              </div>
            </div>

            <!-- Estadísticas -->
            <div class="bg-white rounded-xl border p-4">
              <h4 class="font-semibold">Estadísticas</h4>
              <div class="grid grid-cols-2 gap-3 mt-4 text-sm">
                <div class="p-3 border rounded-lg">
                  <p class="text-gray-500 text-xs">Transacciones</p>
                  <p class="text-lg font-semibold">645</p>
                </div>
                <div class="p-3 border rounded-lg">
                  <p class="text-gray-500 text-xs">Cuentas</p>
                  <p class="text-lg font-semibold">6</p>
                </div>
                <div class="p-3 border rounded-lg">
                  <p class="text-gray-500 text-xs">Categorías</p>
                  <p class="text-lg font-semibold">18</p>
                </div>
                <div class="p-3 border rounded-lg">
                  <p class="text-gray-500 text-xs">Presupuestos activos</p>
                  <p class="text-lg font-semibold">4</p>
                </div>
              </div>
            </div>

            <!-- Cotizaciones/objetivos -->
            <div class="bg-white rounded-xl border p-4">
              <h4 class="font-semibold">Metas de ahorro</h4>
              <div class="mt-4 space-y-3">
                <div class="p-3 border rounded-lg">
                  <div class="flex items-center justify-between text-sm">
                    <span>Fondo emergencia (€1.500)</span>
                    <span class="font-medium">€ 900</span>
                  </div>
                  <div class="mt-2 w-full bg-gray-100 h-2 rounded">
                    <div class="h-2 bg-emerald-500 rounded" style="width: 60%"></div>
                  </div>
                </div>
                <div class="p-3 border rounded-lg">
                  <div class="flex items-center justify-between text-sm">
                    <span>Portátil nuevo (€1.000)</span>
                    <span class="font-medium">€ 300</span>
                  </div>
                  <div class="mt-2 w-full bg-gray-100 h-2 rounded">
                    <div class="h-2 bg-emerald-500 rounded" style="width: 30%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabla de transacciones + Próximos pagos -->
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 bg-white rounded-xl border">
              <div class="p-4 flex items-center justify-between">
                <h4 class="font-semibold">Transacciones recientes</h4>
                <button class="text-sm px-3 py-1.5 border rounded-md">Ver todas</button>
              </div>
              <div class="overflow-x-auto">
                <table class="w-full text-sm">
                  <thead>
                    <tr class="text-left text-gray-500 border-y">
                      <th class="px-4 py-2">Fecha</th>
                      <th class="px-4 py-2">Descripción</th>
                      <th class="px-4 py-2">Categoría</th>
                      <th class="px-4 py-2">Cuenta</th>
                      <th class="px-4 py-2 text-right">Importe</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(t, i) in recentTx" :key="i" class="border-b">
                      <td class="px-4 py-2">{{ t.date }}</td>
                      <td class="px-4 py-2">{{ t.desc }}</td>
                      <td class="px-4 py-2">{{ t.cat }}</td>
                      <td class="px-4 py-2">{{ t.account }}</td>
                      <td class="px-4 py-2 text-right"
                          :class="t.amount < 0 ? 'text-red-600' : 'text-emerald-600'">
                        {{ t.amount < 0 ? '-€ ' + Math.abs(t.amount).toFixed(2) : '€ ' + t.amount.toFixed(2) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="bg-white rounded-xl border">
              <div class="p-4 flex items-center justify-between">
                <h4 class="font-semibold">Próximos pagos</h4>
                <button class="text-sm px-3 py-1.5 border rounded-md">Gestionar</button>
              </div>
              <ul class="divide-y text-sm">
                <li v-for="(b, i) in upcomingBills" :key="i" class="px-4 py-3 flex items-center justify-between">
                  <div>
                    <p class="font-medium">{{ b.name }}</p>
                    <p class="text-xs text-gray-500">{{ b.due }} • {{ b.status }}</p>
                  </div>
                  <div class="font-semibold">€ {{ b.amount.toFixed(2) }}</div>
                </li>
              </ul>
            </div>
          </div>

          <!-- Presupuestos -->
          <div class="bg-white rounded-xl border p-4">
            <div class="flex items-center justify-between">
              <h4 class="font-semibold">Presupuestos del mes</h4>
              <button class="text-sm px-3 py-1.5 border rounded-md">Configurar</button>
            </div>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <div v-for="(b, i) in budgets" :key="i" class="p-4 border rounded-lg">
                <p class="text-sm text-gray-500">{{ b.cat }}</p>
                <div class="mt-2 flex items-center justify-between text-sm">
                  <span class="font-medium">€ {{ b.used }}</span>
                  <span class="text-gray-500">de € {{ b.limit }}</span>
                </div>
                <div class="mt-2 w-full bg-gray-100 h-2 rounded">
                  <div class="h-2 bg-indigo-600 rounded" :style="`width: ${pct(b.used,b.limit)}%`"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500">{{ pct(b.used,b.limit) }}% usado</p>
              </div>
            </div>
          </div>

          <!-- Bloques rápidos -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="p-4 bg-white rounded-xl border">
              <h4 class="font-semibold mb-2">Net Worth</h4>
              <p class="text-2xl font-semibold">€ 12,340</p>
              <p class="text-xs text-gray-500 mt-1">+€210 este mes</p>
            </div>
            <div class="p-4 bg-white rounded-xl border">
              <h4 class="font-semibold mb-2">Inversiones</h4>
              <p class="text-sm text-gray-500">Cartera</p>
              <ul class="mt-2 text-sm space-y-1">
                <li class="flex justify-between"><span>ETF S&P 500</span><span>+2.1%</span></li>
                <li class="flex justify-between"><span>BTC</span><span>-0.8%</span></li>
                <li class="flex justify-between"><span>Bonos UE</span><span>+0.3%</span></li>
              </ul>
            </div>
            <div class="p-4 bg-white rounded-xl border">
              <h4 class="font-semibold mb-2">Alertas</h4>
              <ul class="list-disc pl-4 text-sm space-y-1">
                <li>Presupuesto de Alimentación al 75%.</li>
                <li>Factura de Luz vence en 5 días.</li>
              </ul>
            </div>
            <div class="p-4 bg-white rounded-xl border">
              <h4 class="font-semibold mb-2">Tareas</h4>
              <ul class="text-sm space-y-1">
                <li>✔️ Reconciliar cuenta BBVA</li>
                <li>⬜ Subir extracto Visa</li>
                <li>⬜ Revisar suscripciones</li>
              </ul>
            </div>
          </div>

          <div class="h-10"></div>
        </div>
      </section>
    </div>
  </div>
</template>
