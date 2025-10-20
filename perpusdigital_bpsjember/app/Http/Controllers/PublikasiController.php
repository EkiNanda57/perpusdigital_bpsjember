<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    /**
     * Menampilkan daftar publikasi sesuai role user.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admin bisa melihat semua publikasi
            $publikasi = Publikasi::with('kategori')->latest()->paginate(10);
        } 
        elseif ($user->hasRole('operator')) {
            // Operator hanya bisa melihat publikasi yang dia upload
            // dan hanya yang berstatus tertunda atau diterima
            $publikasi = Publikasi::with('kategori')
                ->where('uploaded_by', $user->id)
                ->whereIn('status', ['tertunda', 'diterima'])
                ->latest()
                ->paginate(10);
        } 
        else {
            // Pengguna umum hanya bisa melihat publikasi yang sudah diterima
            $publikasi = Publikasi::with('kategori')
                ->where('status', 'diterima')
                ->latest()
                ->paginate(10);
        }

        return view('publikasi.publikasi', compact('publikasi'));
    }

    /**
     * Menampilkan form untuk membuat publikasi baru.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('publikasi.create', compact('kategoris'));
    }

    /**
     * Menyimpan publikasi baru ke database.
     */
    public function store(Request $request)
{
    $request->validate([
        'id_kategori' => 'required|exists:kategori,id',
        'judul' => 'required|string|max:255',
        'file_publikasi' => 'required|mimes:pdf,epub,docx,xlsx,xls|max:10240',
        'status' => 'required|in:tertunda,diterima,ditolak',
    ]);

    $file = $request->file('file_publikasi');
    $filename = $file->getClientOriginalName(); // ambil nama asli file
    $path = $file->storeAs('publikasi', $filename, 'public'); // simpan dengan nama aslinya

    Publikasi::create([
        'id_kategori' => $request->id_kategori,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'file_path' => $path,
        'original_name' => $file->getClientOriginalName(),
        'tipe_file' => $file->extension(),
        'status' => $request->status,
        'uploaded_by' => auth()->id(),
    ]);

    return redirect()->route('publikasi.publikasi')->with('success', 'Publikasi berhasil ditambahkan.');
}

    /**
     * Menampilkan form untuk mengedit publikasi.
     */
    public function edit(Publikasi $publikasi)
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('publikasi.editpublikasi', compact('publikasi', 'kategoris'));
    }

    /**
     * Memperbarui publikasi.
     */
    public function update(Request $request, Publikasi $publikasi)
    {
       $request->validate([
    'judul' => 'required|string|max:255',
    'deskripsi' => 'nullable|string',
    'id_kategori' => 'required|exists:kategoris,id',
    'file_publikasi' => 'required|mimes:pdf,epub,docx,xlsx,xls|max:10240', // 10MB = 10240 KB
    'status' => 'required|in:tertunda,diterima,ditolak',
]);


        $path = $publikasi->file_path;
        if ($request->hasFile('file')) {
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName(); // nama asli
        $filePath = $file->storeAs('publikasi', $originalName, 'public'); // simpan dengan nama asli

        $publikasi->file_path = $filePath;
    }

        
        $publikasi->update([
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
            'tipe_file' => $request->hasFile('file_publikasi') 
                ? $request->file('file_publikasi')->extension()
                : $publikasi->tipe_file,
            'status' => $request->status,
        ]);

        return redirect()->route('publikasi.publikasi')->with('success', 'Publikasi berhasil diperbarui.');
    }

    /**
     * Menghapus publikasi.
     */
    public function destroy(Publikasi $publikasi)
    {
        Storage::disk('public')->delete($publikasi->file_path);
        $publikasi->delete();
        return redirect()->route('publikasi.publikasi')->with('success', 'Publikasi berhasil dihapus.');
    }

    /**
     * Detail publikasi.
     */
    public function show($id)
    {
        $publikasi = Publikasi::with('kategori')->findOrFail($id);
        return view('publikasi.detailpublikasi', compact('publikasi'));
    }

    /**
     * Unduh file publikasi.
     */
    public function unduh($id)
{
    $publikasi = Publikasi::findOrFail($id);
    $path = storage_path('app/public/' . $publikasi->file_path);

    return response()->download($path, $publikasi->original_name);
}


    /**
     * Validasi publikasi (khusus admin).
     */
    public function validasi(Request $request, $id)
    {
        $publikasi = Publikasi::findOrFail($id);

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $publikasi->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Publikasi berhasil divalidasi sebagai ' . $request->status . '.');
    }

    public function approve($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        $publikasi->update(['status' => 'diterima']);
        return redirect()->back()->with('success', 'Publikasi diterima.');
    }

    public function reject($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        $publikasi->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Publikasi ditolak.');
    }

    public function landing()
    {
        // Ambil hanya publikasi yang sudah diterima
        $publikasi = \App\Models\Publikasi::where('status', 'diterima')->get();

        // Kirim data ke view landingpage.blade.php
        return view('landingpage', compact('publikasi'));
    }

    public function publikasipengguna($kategori)
{
    // Cari ID kategori dari tabel kategori
    $kategoriModel = \App\Models\Kategori::where('nama_kategori', $kategori)->first();

    if (!$kategoriModel) {
        abort(404, 'Kategori tidak ditemukan');
    }

    // Ambil publikasi berdasarkan kategori_id dan status
    $publikasi = \App\Models\Publikasi::with('kategori')
    ->whereHas('kategori', function ($query) use ($kategori) {
        $query->where('nama_kategori', $kategori);})
    ->where('status', 'diterima')
    ->get();

    return view('publikasi.publikasipengguna', compact('publikasi', 'kategori'));
}

public function detailPengguna($id)
{
    $publikasi = \App\Models\Publikasi::with('kategori')->findOrFail($id);
    return view('publikasi.detailpublikasipengguna', compact('publikasi'));
}

}
