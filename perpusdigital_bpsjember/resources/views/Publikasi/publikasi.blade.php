@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-orange-500 mb-4 sm:mb-0">Data Publikasi</h2>

        {{-- jika role admin, muncul fitur tanggal dan kategori --}}
        @if(auth()->user()->hasRole('admin'))
            <div class="flex items-center space-x-2">
                {{-- Filter kategori --}}
                <select id="categoryFilter" name="kategori"
                    class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                    onchange="filterPublikasi()">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::orderBy('nama_kategori')->get() as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter tanggal --}}
                <input type="date" id="dateFilter" name="date" value="{{ request('date') }}"
                    class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                    onchange="filterPublikasi()">
            </div>
        @endif

        {{-- jika role operator, hanya muncul fitur tambah publikasi saja --}}
        @if(auth()->user()->hasRole('operator'))
        <a href="{{ route('publikasi.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Publikasi
        </a>
    @endif
</div>

    {{-- Session Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto border-collapse hidden md:table">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold">File</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 align-middle">
            @forelse($publikasi as $index => $item)
                <tr class="border-b hover:bg-gray-50 align-middle">
                    <td class="px-4 py-3 text-center align-middle">
                        {{ ($publikasi->currentPage() - 1) * $publikasi->perPage() + $index + 1 }}
                    </td>
                    <td class="px-4 py-3 font-medium align-middle">{{ $item->judul }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 align-middle">
                        {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                    </td>
                    <td class="px-4 py-3 align-middle">
                        @switch($item->status)
                            @case('tertunda')
                                <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Tertunda</span>
                                @break
                            @case('diterima')
                                <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Diterima</span>
                                @break
                            @case('ditolak')
                                <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Ditolak</span>
                                @break
                            @default
                                <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Draft</span>
                        @endswitch
                    </td>
                    <td class="px-4 py-3 text-center align-middle">
                        @if($item->file_path)
                            <a href="{{ route('publikasi.detailpublikasi', $item->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada file</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 align-middle">
                        <div class="flex justify-center items-center gap-2">
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
                                <a href="{{ route('publikasi.editpublikasi', $item->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                    Edit
                                </a>
                            @endif

                            @if(auth()->user()->hasRole('admin') && $item->status === 'tertunda')
                                <form action="{{ route('publikasi.approve', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('publikasi.reject', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition duration-300">
                                        Tolak
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-6">Belum ada data publikasi.</td>
                </tr>
            @endforelse
        </tbody>
        </table>

        {{-- Mobile Version --}}
        <div class="md:hidden">
            @forelse($publikasi as $index => $item)
                <div class="border rounded-lg p-4 mb-4 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-gray-800">{{ $item->judul }}</h3>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($item->status === 'tertunda') bg-yellow-200 text-yellow-800
                            @elseif($item->status === 'diterima') bg-green-200 text-green-800
                            @elseif($item->status === 'ditolak') bg-red-200 text-red-800
                            @else bg-gray-200 text-gray-800 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">
                        Kategori: <span class="font-medium">{{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                    </p>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('publikasi.detailpublikasi', $item->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition">
                            Lihat
                        </a>

                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
                            <a href="{{ route('publikasi.editpublikasi', $item->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition">
                                Edit
                            </a>
                        @endif

                        @if(auth()->user()->hasRole('admin') && $item->status === 'tertunda')
                            <form action="{{ route('publikasi.approve', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded-md transition">
                                    Terima
                                </button>
                            </form>

                            <form action="{{ route('publikasi.reject', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition">
                                    Tolak
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-6">Belum ada data publikasi.</p>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $publikasi->links('pagination::tailwind') }}
    </div>
</div>

<script>
function filterPublikasi() {
    const baseUrl = "{{ route('publikasi.publikasi') }}";
    const kategori = document.getElementById('categoryFilter')?.value;
    const date = document.getElementById('dateFilter')?.value;

    let params = [];
    if (kategori) params.push(`kategori=${kategori}`);
    if (date) params.push(`date=${date}`);

    const url = params.length ? `${baseUrl}?${params.join('&')}` : baseUrl;
    window.location.href = url;
}
</script>

@endsection
