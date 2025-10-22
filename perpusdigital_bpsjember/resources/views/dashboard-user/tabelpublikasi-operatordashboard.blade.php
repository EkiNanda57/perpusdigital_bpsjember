@extends('layouts.sidebar')

@section('title', 'Dashboard Operator')

@section('content')

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">Publikasi Terbaru Saya</h3>

            <!-- 🔍 Kolom pencarian -->
            <div class="flex items-center space-x-2">
                <input type="text" id="search" placeholder="Cari judul publikasi..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"/>
                <input type="date" id="date" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"/>
            </div>
        </div>
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
                    @forelse ($recentPublications as $publikasi)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $publikasi->judul }}</td>
                        <td class="px-4 py-3 align-middle">
                            @switch($publikasi->status)
                                @case('tertunda')
                                    <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Tertunda
                                    </span>
                                    @break

                                @case('diterima')
                                    <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Diterima
                                    </span>
                                    @break

                                @case('ditolak')
                                    <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Ditolak
                                    </span>
                                    @break

                                @default
                                    <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Draft
                                    </span>
                            @endswitch
                        </td>
                        <td class="py-3 px-4">{{ $publikasi->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('operator.detailpublikasi', $publikasi->id) }}" class="text-blue-600 hover:underline">Detail</a>
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
    </div>
<div class="flex items-center justify-end mt-4 pr-4 text-sm text-gray-600">
    <div class="pagination-container mr-3">
        {{ $recentPublications->onEachSide(1)->links('pagination::tailwind') }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const dateInput = document.getElementById('date');
    const tbody = document.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');

    // Tambahkan elemen pesan kosong (disembunyikan dulu)
    const emptyMessage = document.createElement('tr');
    emptyMessage.innerHTML = `
        <td colspan="4" class="py-4 px-4 text-center text-gray-500">
            Tidak ada data yang cocok.
        </td>
    `;
    emptyMessage.style.display = 'none';
    tbody.appendChild(emptyMessage);

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const dateValue = dateInput.value;
        let visibleCount = 0;

        rows.forEach(row => {
            // Lewati baris pesan kosong
            if (row === emptyMessage) return;

            const title = row.children[0]?.textContent.toLowerCase();
            const dateText = row.children[2]?.textContent.trim();

            const matchSearch = title.includes(searchValue);
            const matchDate = !dateValue || dateText.includes(formatDate(dateValue));

            if (matchSearch && matchDate) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // tampilkan pesan kalau tidak ada baris yang cocok
        emptyMessage.style.display = visibleCount === 0 ? '' : 'none';
    }

    // Format tanggal agar cocok dengan tampilan di tabel (dd Mmm yyyy)
    function formatDate(dateStr) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-GB', options).replace(/ /g, ' ');
    }

    searchInput.addEventListener('input', filterTable);
    dateInput.addEventListener('change', filterTable);
});
</script>


@endsection
