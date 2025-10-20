@extends('layouts.landingpages')

@section('title', 'Publikasi')

@section('content')
<div class="container mx-auto py-10 px-6">
    <h2 class="text-2xl font-bold text-orange-600 mb-6">Data Publikasi</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-center w-32">File</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($publikasi as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ $item->judul }}</td>
                        <td class="py-3 px-4">{{ $item->kategori->nama_kategori ?? '_' }}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('publikasi.detailpublikasipengguna', $item->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                               Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Belum ada publikasi pada kategori ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tombol kembali di kanan -->
    <div class="flex justify-end mt-6">
        <a href="{{ url('/') }}" 
           class="bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition">
           Kembali
        </a>
    </div>
</div>
@endsection
