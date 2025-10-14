@extends('layouts.sidebar')

@section('content')
<div class="w-full px-4 sm:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6 sm:p-8 border border-gray-100 w-full">
        <h5 class="text-lg font-semibold text-blue-900 mb-6">
            Edit Kategori
        </h5>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-4">
                <label for="nama_kategori" class="text-gray-700 font-medium">
                    Nama Kategori
                </label>
                <div class="sm:col-span-3">
                    <input type="text" name="nama_kategori" id="nama_kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                           placeholder="Nama" required>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 sm:justify-start">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition w-full sm:w-auto">
                    Update
                </button>

                <a href="{{ route('kategori.kategori') }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-lg transition w-full sm:w-auto text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
