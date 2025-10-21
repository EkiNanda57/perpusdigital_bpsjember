@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-orange-500 mb-6">
            Detail Publikasi
        </h2>

        <div class="space-y-4 text-gray-700">
            <div>
                <h3 class="font-semibold text-lg text-blue-900">Judul</h3>
                <p>{{ $publikasi->judul }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg text-blue-900">Deskripsi</h3>
                <p>{{ $publikasi->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg text-blue-900">Kategori</h3>
                  <p class="text-gray-700">
                  {{ $publikasi->kategori ? $publikasi->kategori->nama_kategori : 'Tidak ada kategori' }}
                  </p>


            </div>

            <div>
                <h3 class="font-semibold text-lg text-blue-900">Status</h3>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $publikasi->status == 'diterima' ? 'bg-green-200 text-green-700' :
                       ($publikasi->status == 'ditolak' ? 'bg-red-200 text-red-700' : 'bg-yellow-200 text-yellow-700') }}">
                    {{ ucfirst($publikasi->status) }}
                </span>
            </div>

            <div>
                <h3 class="font-semibold text-lg text-blue-900">Diupload Oleh</h3>
                <p>{{ $publikasi->user->name ?? 'Admin' }}</p>
            </div>

<div>
    <h3 class="font-semibold text-lg text-blue-900">File Publikasi</h3>
    @if($publikasi->file_path)
        <div class="mt-3 flex flex-col items-start gap-2">
            {{-- Tombol Unduh --}}
            <a href="{{ route('publikasi.unduh', $publikasi->id) }}" 
               class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 transition">
                Unduh
            </a>

            {{-- Deskripsi tipe file --}}
            <p class="text-gray-600 text-sm mt-1">
                File yang diunggah bertipe 
                <span class="font-semibold text-blue-900">
                    {{ strtoupper($publikasi->tipe_file ?? 'Tidak diketahui') }}
                </span>.
            </p>
        </div>
    @else
        <p class="text-gray-500 mt-2">Tidak ada file yang diunggah.</p>
    @endif
</div>

            <div>
                <h3 class="font-semibold text-lg text-blue-900">Tanggal Upload</h3>
                <p>{{ $publikasi->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('dashboard-user.operator-dashboard') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
               Kembali ke Data Publikasi
            </a>
        </div>
    </div>
</div>
@endsection
