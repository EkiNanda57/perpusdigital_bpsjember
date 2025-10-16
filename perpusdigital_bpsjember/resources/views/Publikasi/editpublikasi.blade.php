@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-orange-500">Edit Publikasi</h2>
        <a href="{{ route('publikasi.publikasi') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
            Kembali
        </a>
    </div>

    {{-- Form Container --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Tampilkan Error Validasi --}}
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

        <form action="{{ route('publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Input Judul --}}
            <div class="mb-4">
                <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">
                    Judul Publikasi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" 
                       value="{{ old('judul', $publikasi->judul) }}"
                       class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight 
                              focus:outline-none focus:ring-2 focus:ring-orange-500"
                       placeholder="Masukkan judul publikasi" required>
            </div>

            {{-- Input Deskripsi --}}
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight 
                                 focus:outline-none focus:ring-2 focus:ring-orange-500"
                          placeholder="Masukkan deskripsi singkat tentang publikasi">{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
            </div>

            {{-- Input Kategori --}}
            <div class="mb-4">
                <label for="id_kategori" class="block text-gray-700 text-sm font-bold mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="id_kategori" name="id_kategori"
                        class="shadow border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight 
                               focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <option value="" disabled>-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" 
                                {{ old('id_kategori', $publikasi->id_kategori) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Upload File --}}
            <div class="mb-6">
                <label for="file_publikasi" class="block text-gray-700 text-sm font-bold mb-2">
                    Upload File (Opsional)
                </label>
                <div class="mb-2 text-sm text-gray-600">
                    File saat ini: 
                    <a href="{{ asset('storage/' . $publikasi->file_path) }}" target="_blank" 
                       class="text-blue-500 hover:underline">
                        {{ basename($publikasi->file_path) }}
                    </a>
                </div>
                <input type="file" id="file_publikasi" name="file_publikasi"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
                              bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti file.</p>
            </div>

            {{-- Input Status --}}
           <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Status Publikasi
            </label>
            <p class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg text-sm">
                Status saat ini: <strong>Tertunda</strong> (menunggu persetujuan admin)
            </p>
            <input type="hidden" name="status" value="tertunda">
        </div>


            {{-- Tombol Simpan --}}
            <div class="flex items-center justify-end">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg 
                               focus:outline-none focus:shadow-outline transition duration-300">
                    Update Publikasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
