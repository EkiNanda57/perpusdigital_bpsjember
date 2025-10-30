@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h3>

        <!-- 🔍 Kolom pencarian -->
        <div class="flex items-center space-x-2">
            <input type="text" id="search" placeholder="Cari pengguna..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"/>
            <input type="date" id="date" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"/>
        </div>
    </div>

    <!-- 🔄 Bagian tabel yang nanti diganti secara dinamis -->
    <div class="overflow-x-auto" id="users-table">
        <table class="min-w-full text-sm text-grey-700">
            <thead class="bg-gradient-to-r from-orange-400 to-yellow-300 text-gray-800">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Sebagai</th>
                    <th class="py-3 px-4 text-left">Tanggal Bergabung</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-orange-50 transition">
                    <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                    <td class="py-3 px-4">{{ $user->email }}</td>
                    <td class="py-3 px-4 capitalize">
                        {{ $user->roles->first()->role_name ?? 'Tanpa Role' }}
                    </td>
                    <td class="py-3 px-4">
                        {{ $user->created_at->translatedFormat('d F Y') }}
                    </td>
                    <td class="py-3 px-4">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            {{-- <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                Hapus
                            </button> --}}
                            <button type="submit"
                                    class="text-gray-400 hover:text-red-600 transition"
                                    title="Hapus Pengguna">
                                <!-- Ikon Sampah (SVG) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="border-b">
                    <td colspan="5" class="py-3 px-4 text-center text-gray-500">
                        Belum ada pengguna yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4" id="pagination-wrapper">
    <div class="pagination-container flex items-center justify-between text-sm text-gray-600">

        {{-- Info "Showing 1 to 8..." --}}
        <div class="pagination-info">
            Menampilkan <span class="font-bold">{{ $users->firstItem() }}</span>
            sampai <span class="font-bold">{{ $users->lastItem() }}</span>
            dari <span class="font-bold">{{ $users->total() }}</span> hasil
        </div>

        {{-- Tombol Pagination --}}
        <div class="pagination-links">
            {{ $users->appends(request()->query())->links('pagination::tailwind') }}
        </div>

    </div>
</div>

<!-- ⚡ Tambahkan script di bawah ini -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const dateInput = document.getElementById('date');
    const tableContainer = document.getElementById('users-table');
    const paginationContainer = document.querySelector('.pagination-container');

    function fetchUsers(page = 1) {
        const search = searchInput.value;
        const date = dateInput.value;

        fetch(`{{ route('admin.users.index') }}?search=${encodeURIComponent(search)}&date=${encodeURIComponent(date)}&page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');

            // Ganti isi tabel
            const newTable = newDoc.querySelector('#users-table').innerHTML;
            tableContainer.innerHTML = newTable;

            // Ganti pagination
            const newPaginationInfo = newDoc.querySelector('.pagination-info').innerHTML;
            const newPaginationLinks = newDoc.querySelector('.pagination-links').innerHTML;

            paginationContainer.querySelector('.pagination-info').innerHTML = newPaginationInfo;
            paginationContainer.querySelector('.pagination-links').innerHTML = newPaginationLinks;

            // Aktifkan ulang event untuk tombol pagination
            attachPaginationEvents();
        })
        .catch(error => console.error('Error fetching users:', error));
    }

    function attachPaginationEvents() {
        const paginationLinks = document.querySelectorAll('.pagination-container a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchUsers(page);
            });
        });
    }

    searchInput.addEventListener('input', () => fetchUsers(1));
    dateInput.addEventListener('change', () => fetchUsers(1));

    attachPaginationEvents();
});
</script>

@endsection
