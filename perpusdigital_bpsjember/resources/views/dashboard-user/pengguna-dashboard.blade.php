{{-- Beritahu Blade untuk menggunakan layout dari layouts/sidebar.blade.php --}}
@extends('layouts.sidebar')

{{-- Isi 'slot' title di layout induk --}}
@section('title', 'Dashboard Admin')

{{-- Mulai bagian konten --}}
@section('content')

{{-- LETAKKAN HANYA KONTEN SPESIFIK HALAMAN INI DI SINI --}}

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-600">Pengguna Terdaftar</h3>
        <p class="text-3xl font-bold mt-2">1,250</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-600">Publikasi Terbit</h3>
        <p class="text-3xl font-bold mt-2">82</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-600">Kategori Buku</h3>
        <p class="text-3xl font-bold mt-2">15</p>
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
                    <td class="py-2 px-4">Pengguna</td>
                    <td class="py-2 px-4">2025-10-13</td>
                </tr>
                 <tr class="border-b">
                    <td class="py-2 px-4">Agus Wijaya</td>
                    <td class="py-2 px-4">agus.w@example.com</td>
                    <td class="py-2 px-4">Operator</td>
                    <td class="py-2 px-4">2025-10-12</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
{{-- Akhir bagian konten --}}
