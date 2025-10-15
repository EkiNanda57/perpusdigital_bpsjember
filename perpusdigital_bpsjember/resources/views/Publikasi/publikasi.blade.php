@extends('layouts.sidebar')

@section('content')

<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-orange-500 mb-4 sm:mb-0">Data Publikasi</h2>
        <a href="{{ route('publikasi.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Publikasi
        </a>
    </div>

    {{-- Session Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif  

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold">File</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($publikasi as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">
                            {{ ($publikasi->currentPage() - 1) * $publikasi->perPage() + $index + 1 }}
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $item->judul }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($item->status == 'published')
                                <span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">
                                    Published
                                </span>
                            @else
                                <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($item->file_path)
                                <a href="{{ route('publikasi.detailpublikasi', $item->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                Lihat
                            </a>
                            @else
                                <span class="text-gray-400 text-sm">Tidak ada file</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 flex justify-center items-center gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('publikasi.editpublikasi', $item->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('publikasi.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus publikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-6">
                            Belum ada data publikasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $publikasi->links('pagination::tailwind') }}
    </div>

</div>
@endsection
