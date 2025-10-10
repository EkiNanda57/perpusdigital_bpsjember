<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <div class="flex flex-1">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col min-h-screen">
            
            <!-- Navbar -->
            <header class="bg-white shadow py-4 px-4 sm:px-6 flex items-center justify-between">
                <!-- Bagian kiri (toggle + judul) -->
                <div class="flex items-center gap-3">
    <button id="sidebar-toggle" class="md:hidden bg-orange-500 text-white p-2 rounded-md focus:outline-none flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <h2 class="text-lg sm:text-xl font-semibold text-orange-500 truncate">
        @yield('title', 'Dashboard')
    </h2>
</div>


                <!-- Bagian kanan (user info) -->
                <div class="flex items-center space-x-2">
                    <span class="text-gray-700 font-medium hidden sm:inline">Halo, Admin 👋</span>
                </div>
            </header>

            <!-- Konten -->
            <main class="flex-grow p-6 bg-gray-50">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-gradient-to-r from-orange-500 to-yellow-400 text-white text-center py-3">
                <p class="text-sm">&copy; 2025 Digital Library - BPS Kabupaten Jember</p>
            </footer>
        </div>
    </div>

    <!-- 🧠 Script Toggle Sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

</body>
</html>
