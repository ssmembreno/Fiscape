<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fiscape</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex" x-data="{ sidebarOpen: false }">

    <!-- Botón menú hamburguesa solo visible en móviles -->
    <button @click="sidebarOpen = !sidebarOpen"
            class="absolute top-4 left-4 z-50 text-gray-800 md:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside
        class="bg-gray-900 text-white w-64 min-h-screen px-4 py-6 flex flex-col justify-between 
               fixed md:static z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
        :class="{ 'translate-x-0': sidebarOpen }"
        id="sidebar">

        <div>
            <h1 class="text-2xl font-bold mb-5 pl-2 tracking-wide">💵 FISCAPE</h1>
            <p class="text-xl font-bold mb-10 pl-2 tracking-wide">Mis Finanzas</p>
            <nav class="flex flex-col gap-2 text-sm">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition bg-gray-800 font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 20V10h10v10H10zM0 10h10v10H0V10zM10 0h10v10H10V0zM0 0h10v10H0V0z"/></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">🍽️ Tables</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    📅 Reservations
                    <span class="ml-auto bg-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">2</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">🧑‍🍳 Waiters</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">📋 Menu</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">👥 Customers</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">📊 Reports</a>
            </nav>
        </div>

        <div class="mt-10 px-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-sm text-gray-300 hover:text-white">Cerrar sesión</button>
            </form>
            <div class="mt-4 text-xs text-gray-400">
                <p class="text-xl text-left">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 w-full p-6 min-h-screen" id="app">
        @yield('content')
    </main>
</div>

@vite('resources/js/app.js')
</body>
</html>
