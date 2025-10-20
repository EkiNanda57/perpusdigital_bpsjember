@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')

<!-- 🌼 Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-700 font-medium">Jumlah Pengguna</h3>
                <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($userCount) }}</p>
            </div>
            <span class="text-4xl">👥</span>
        </div>
    </div>
    <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-700 font-medium">Jumlah Publikasi Masuk</h3>
                <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($publicationCount) }}</p>
            </div>
            <span class="text-4xl">📩</span>
        </div>
    </div>
    <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-700 font-medium">Publikasi Diterima</h3>
                <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($acceptedPublicationCount) }}</p>
            </div>
            <span class="text-4xl">🗳</span>
        </div>
    </div>
    <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-700 font-medium">Jumlah Kategori</h3>
                <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($categoryCount) }}</p>
            </div>
            <span class="text-4xl">🗂</span>
        </div>
    </div>
</div>

<!-- Tabel Pengguna Terbaru -->
<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h3>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-orange-700 hover:text-orange-500 transition">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-grey-700">
            <thead class="bg-gradient-to-r from-orange-400 to-yellow-300 text-gray-800">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Sebagai</th>
                    <th class="py-3 px-4 text-left">Tanggal Bergabung</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-orange-50 transition">
                    <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                    <td class="py-3 px-4">{{ $user->email }}</td>
                    <td class="py-3 px-4 capitalize">
                        {{ $user->roles->first()->role_name ?? 'Tanpa Role' }}
                    </td>
                    <td class="py-3 px-4">
                        {{ $user->created_at->translatedFormat('d F Y') }}
                    </td>
                    <td class="py-3 px-4">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-gray-400 hover:text-red-600 transition"
                                    title="Hapus Pengguna">
                                <!-- Ikon Sampah (SVG) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="border-b">
                    <td colspan="5" class="py-3 px-4 text-center text-gray-500">
                        Belum ada pengguna yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
