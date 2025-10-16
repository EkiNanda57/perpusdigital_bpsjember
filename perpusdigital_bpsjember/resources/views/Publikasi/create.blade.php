@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-orange-500">Tambah Publikasi Baru</h2>
        <a href="{{ route('publikasi.publikasi') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
            Kembali
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Menampilkan Error Validasi Jika Ada --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('publikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Input Judul Publikasi --}}
            <div class="mb-4">
                <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Publikasi <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                       class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500"
                       placeholder="Masukkan judul publikasi" required>
            </div>

            {{-- Input Deskripsi --}}
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500"
                          placeholder="Masukkan deskripsi singkat tentang publikasi">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="id_kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="id_kategori" name="id_kategori"
                        class="shadow border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    {{-- Loop untuk menampilkan semua kategori yang dikirim dari controller --}}
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                            {{-- Sesuaikan 'nama_kategori' dengan nama kolom di tabel Anda --}}
                            {{ $kategori->nama_kategori }} 
                        </option>
                    @endforeach
                </select>  
            </div>

            {{-- Input Upload File --}}
            <div class="mb-6">
                <label for="file_publikasi" class="block text-gray-700 text-sm font-bold mb-2">Upload File <span class="text-red-500">*</span></label>
                <input type="file" id="file_publikasi" name="file_publikasi"
       accept=".pdf,.epub,.docx,.xlsx,.xls"
       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
        <p class="mt-1 text-xs text-gray-500">
           Tipe file: PDF, EPUB, DOCX, XLSX, XLS. Maksimal ukuran: 10MB.
        </p>


            {{-- Input Status --}}
            <div class="mb-6">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status"
                        class="shadow border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <option value="tertunda" {{ old('status') == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                    <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>


            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Simpan Publikasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection