@extends('layouts.sidebar')

@section('content')

<div class="container mx-auto px-4 py-8">
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg">
<div class="bg-orange-500 p-4 rounded-t-lg">
<h2 class="text-2xl font-bold text-white">Edit Publikasi</h2>
</div>

    <form action="{{ route('publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT') {{-- Penting untuk form edit --}}

        {{-- Input Judul --}}
        <div class="mb-4">
            <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Publikasi:</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $publikasi->judul) }}"
                   class="shadow appearance-none border @error('judul') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500" 
                   placeholder="Masukkan judul buku atau jurnal" required>
            @error('judul')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Deskripsi --}}
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      class="shadow appearance-none border @error('deskripsi') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500"
                      placeholder="Masukkan sinopsis singkat...">{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input File --}}
        <div class="mb-6">
            <label for="file_publikasi" class="block text-gray-700 text-sm font-bold mb-2">Upload File Baru (Opsional):</label>
            <div class="mb-2">
                <span class="text-sm text-gray-600">File saat ini:</span>
                <a href="{{ asset('storage/' . $publikasi->file_path) }}" target="_blank" class="text-blue-500 hover:underline text-sm">{{ basename($publikasi->file_path) }}</a>
            </div>
            <input type="file" id="file_publikasi" name="file_publikasi" 
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file.</p>
            @error('file_publikasi')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Status --}}
        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select name="status" id="status" required 
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="published" {{ old('status', $publikasi->status) == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ old('status', $publikasi->status) == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
             @error('status')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('publikasi.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">
                Batal
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Update Publikasi
            </button>
        </div>
    </form>
</div>

</div>
@endsection