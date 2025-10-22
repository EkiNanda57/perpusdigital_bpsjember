@extends('layouts.sidebar')

@section('title', 'Dashboard Operator')

@section('content')

    <!-- 🌼 Statistik Cards Operator (Dengan Gaya Admin) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Card 1: Total Publikasi Saya -->
        <a href="{{ route('operator.publikasi') }}" class="block">
            <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-700 font-medium">Total Publikasi Saya</h3>
                        <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($jumlahPublikasi) }}</p>
                    </div>
                    <span class="text-4xl">📚</span>
                </div>
            </div>
        </a>

        <!-- Card 2: Publikasi Diterima -->
        <a href="{{ route('operator.publikasi', ['status' => 'diterima']) }}" class="block">
            <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-700 font-medium">Publikasi Diterima</h3>
                        <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($jumlahDiterima) }}</p>
                    </div>
                    <span class="text-4xl">✅</span>
                </div>
            </div>
        </a>

        <!-- Card 3: Publikasi Tertunda -->
        <a href="{{ route('operator.publikasi', ['status' => 'tertunda']) }}"
        class="block bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-700 font-medium">Publikasi Tertunda</h3>
                    <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($jumlahTertunda) }}</p>
                </div>
                <span class="text-4xl">⏳</span>
            </div>
        </a>

        <a href="{{ route('operator.publikasi', ['status' => 'ditolak']) }}" class="block">
            <div class="bg-gradient-to-br from-orange-100 to-orange-100 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-700 font-medium">Publikasi Ditolak</h3>
                        <p class="text-3xl font-extrabold mt-1 text-gray-800">{{ number_format($jumlahDitolak) }}</p>
                    </div>
                    <span class="text-4xl">❌</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Tabel Publikasi Terbaru Saya (Disatukan di sini) -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">Publikasi Terbaru Saya</h3>
            {{-- Nanti link ini bisa diarahkan ke halaman daftar semua publikasi --}}
            <a href="{{ route('operator.publikasi') }}" class="text-sm text-orange-700 hover:text-orange-500 transition">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-orange-400 to-yellow-300 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 text-left">Judul Publikasi</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Tanggal Upload</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPublications as $publikasi)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $publikasi->judul }}</td>
                        <td class="px-4 py-3 align-middle">
                            @switch($publikasi->status)
                                @case('tertunda')
                                    <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Tertunda
                                    </span>
                                    @break

                                @case('diterima')
                                    <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Diterima
                                    </span>
                                    @break

                                @case('ditolak')
                                    <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Ditolak
                                    </span>
                                    @break

                                @default
                                    <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Draft
                                    </span>
                            @endswitch
                        </td>
                        <td class="py-3 px-4">{{ $publikasi->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('operator.detailpublikasi', $publikasi->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">
                            Anda belum mengupload publikasi apapun.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

