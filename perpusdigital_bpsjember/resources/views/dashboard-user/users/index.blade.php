@extends('layouts.sidebar')

@section('title', 'Semua Publikasi Saya')

@section('content')
    <!-- Header Halaman -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Semua Publikasi Saya</h1>
        <p class="text-gray-600">Berikut adalah daftar lengkap publikasi yang telah Anda upload.</p>
    </div>

    <!-- Tabel Daftar Publikasi -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden">
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
                    @forelse ($publications as $publication)
                    <tr class="border-b hover:bg-orange-50 transition">
                        <td class="py-3 px-4 font-medium">{{ $publication->title ?? $publication->judul }}</td>
                        <td class="py-3 px-4">
                            @if($publication->status == 'diterima')
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Diterima</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Tertunda</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $publication->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
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
        
        <!-- Link Paginasi -->
        <div class="p-4 bg-gray-50">
            {{ $publications->links() }}
        </div>
    </div>
@endsection
```

---

