<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menambahkan transisi yang halus untuk sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <aside id="sidebar" class="sidebar bg-gray-800 text-white w-64 fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 z-30">
            <div class="p-4">
                <h2 class="text-2xl font-bold">Dashboard</h2>
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-gray-600">
                    🏠 Home
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    👤 Profil
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    📊 Analitik
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    ⚙️ Pengaturan
                </a>
            </nav>
            <div class="absolute bottom-0 p-4">
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-red-700">
                    🚪 Logout
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col lg:ml-64">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <button id="menu-button" class="lg:hidden text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">
                    {{-- Mengambil role pertama yang dimiliki user --}}
                    @php
                        $role = auth()->user()->roles->first()->role_name;
                    @endphp

                    Selamat Datang, {{ auth()->user()->name }} ({{ $role }})
                </h1>
                <div>
                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                </div>
            </header>

            <main class="flex-1 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-600">Pengguna Terdaftar</h3>
                        <p class="text-3xl font-bold mt-2">1,250</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-600">Pendapatan Hari Ini</h3>
                        <p class="text-3xl font-bold mt-2">$ 3,450</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-600">Pesanan Baru</h3>
                        <p class="text-3xl font-bold mt-2">82</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-600">Total Produk</h3>
                        <p class="text-3xl font-bold mt-2">512</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Pengguna Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 text-left">Nama</th>
                                    <th class="py-2 px-4 text-left">Email</th>
                                    <th class="py-2 px-4 text-left">Peran</th>
                                    <th class="py-2 px-4 text-left">Tanggal Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 px-4">Budi Santoso</td>
                                    <td class="py-2 px-4">budi.s@example.com</td>
                                    <td class="py-2 px-4">Admin</td>
                                    <td class="py-2 px-4">2025-10-14</td>
                                </tr>
                                <tr class="border-b bg-gray-50">
                                    <td class="py-2 px-4">Citra Lestari</td>
                                    <td class="py-2 px-4">citra.l@example.com</td>
                                    <td class="py-2 px-4">Member</td>
                                    <td class="py-2 px-4">2025-10-13</td>
                                </tr>
                                 <tr class="border-b">
                                    <td class="py-2 px-4">Agus Wijaya</td>
                                    <td class="py-2 px-4">agus.w@example.com</td>
                                    <td class="py-2 px-4">Member</td>
                                    <td class="py-2 px-4">2025-10-12</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
