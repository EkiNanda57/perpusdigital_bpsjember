@extends('layouts.sidebar')

@section('title', 'Detail Publikasi')

@section('content')
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-sm text-orange-700 hover:text-orange-500 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Konten Detail -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden p-8">
        
        <!-- Status Badge -->
        <div class="mb-4">
            @if($publication->status == 'diterima')
                <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                    Diterima
                </span>
            @else
                <span class="px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-200 rounded-full">
                    Tertunda
                </span>
            @endif
        </div>

        <!-- Judul -->
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            {{ $publication->title ?? $publication->judul }}
        </h1>

        <!-- Info Tambahan -->
        <p class="text-gray-500 text-sm mb-6">
            Diupload pada {{ $publication->created_at->format('d F Y') }}
        </p>

        <!-- Isi/Deskripsi Publikasi (jika ada) -->
        <div class="prose max-w-none text-gray-700">
            {{-- Ganti 'description' dengan nama kolom Anda untuk isi/deskripsi --}}
            <p>
                {{ $publication->description ?? 'Tidak ada deskripsi.' }}
            </p>
        </div>

    </div>
@endsection
