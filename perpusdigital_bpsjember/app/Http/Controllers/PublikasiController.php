<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    /**
     * Menampilkan daftar semua publikasi.
     */
    public function index()
    {
        // Gunakan with('kategori') untuk Eager Loading (lebih efisien)
        $publikasi = Publikasi::with('kategori')->latest()->paginate(10);
        return view('publikasi.publikasi', compact('publikasi'));
    }

    /**
     * Menampilkan form untuk membuat publikasi baru.
     */
    public function create()
    {
        // Mengambil semua data kategori, diurutkan berdasarkan nama
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
        // Ambil juga semua kategori untuk dropdown
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('publikasi.editpublikasi', compact('publikasi', 'kategoris'));
    }

    /**
     * Memperbarui data publikasi di database.
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
            'id_kategori' => $request->id_kategori, // ✅ disesuaikan
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
        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil dihapus.');
    }


    public function show($id)
{
    $publikasi = Publikasi::with('kategori')->findOrFail($id);
    return view('publikasi.detailpublikasi', compact('publikasi'));
}

public function unduh($id)
{
    $publikasi = Publikasi::findOrFail($id);
    $path = storage_path('app/public/' . $publikasi->file_path);

    return response()->download($path, $publikasi->original_name);
}




}


