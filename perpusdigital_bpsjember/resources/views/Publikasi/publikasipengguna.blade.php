@extends('layouts.landingpages')

@section('title', 'Publikasi')

@section('content')
<div class="container mx-auto py-10 px-6">
    <h2 class="text-2xl font-bold text-orange-600 mb-6">Data Publikasi</h2>

    <div class="flex justify-end mb-3 sm:mb-5">
        <button id="search-toggle-btn" class="p-2 text-gray-600 rounded-lg sm:hidden hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </button>

        <div id="search-inputs-container"
             class="hidden sm:flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
            <input type="text" id="search" placeholder="Cari publikasi..." class="w-full sm:w-80 bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"/>
        </div>
    </div>

    <div class="overflow-x-auto" id="publikasi-table-container">
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

    <div class="flex justify-end mt-6">
        <a href="{{ url('/') }}"
           class="bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition">
            Kembali
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tableContainer = document.getElementById('publikasi-table-container');

    const toggleBtn = document.getElementById('search-toggle-btn');
    const inputsContainer = document.getElementById('search-inputs-container');
    function fetchPublikasi() {
        const search = searchInput.value;
        const url = new URL('{{ url()->current() }}');
        url.searchParams.set('search', search);

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            const newTableContent = newDoc.querySelector('#publikasi-table-container').innerHTML;
            tableContainer.innerHTML = newTableContent;
        })
        .catch(error => console.error('Error fetching publikasi:', error));
    }

    searchInput.addEventListener('input', () => fetchPublikasi());
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            toggleBtn.classList.add('hidden');

            inputsContainer.classList.remove('hidden');
            inputsContainer.classList.add('flex');
        });
    }

});
</script>

@endsection
