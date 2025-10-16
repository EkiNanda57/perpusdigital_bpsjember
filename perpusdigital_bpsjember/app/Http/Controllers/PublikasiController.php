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
    'file_publikasi' => 'nullable|mimes:pdf,epub,docx,xlsx,xls,png,jpg,jpeg,mp4|max:20480',
    'file_url' => 'nullable|url',
]);


    // ❗ Wajib isi salah satu: file ATAU link
    if (!$request->hasFile('file_publikasi') && !$request->filled('file_url')) {
        return back()
            ->withErrors(['file_publikasi' => 'Harap unggah file atau isi link publikasi.'])
            ->withInput();
    }

    // Variabel default
    $path = null;
    $originalName = null;
    $tipeFile = null;

    // Kalau user upload file
    if ($request->hasFile('file_publikasi')) {
        $file = $request->file('file_publikasi');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('publikasi', $originalName, 'public');
        $tipeFile = $file->extension();
    } 
    // Kalau user isi link
    elseif ($request->filled('file_url')) {
        $path = $request->file_url;
        $originalName = basename($request->file_url);
        $tipeFile = pathinfo($originalName, PATHINFO_EXTENSION) ?: 'url';
    }

    // Simpan ke database
    Publikasi::create([
    'id_kategori' => $request->id_kategori,
    'judul' => $request->judul,
    'deskripsi' => $request->deskripsi,
    'file_path' => $path,
    'original_name' => $originalName,
    'tipe_file' => $tipeFile,
    'status' => 'tertunda', // ← status otomatis
    'uploaded_by' => auth()->id(),
]);


    return redirect()->route('publikasi.publikasi')
        ->with('success', 'Publikasi berhasil ditambahkan.');
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
     * Memperbarui data publikasi di database.
     */
    public function update(Request $request, Publikasi $publikasi)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'id_kategori' => 'required|exists:kategori,id',
        'file_publikasi' => 'nullable|mimes:pdf,epub,docx,xlsx,xls,png,jpg,jpeg,mp4|max:20480',
        'file_url' => 'nullable|url',
        'status' => 'required|in:tertunda,diterima,ditolak',
    ]);

    $path = $publikasi->file_path;
    $originalName = $publikasi->original_name;
    $tipeFile = $publikasi->tipe_file;

    if ($request->hasFile('file_publikasi')) {
        $file = $request->file('file_publikasi');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('publikasi', $originalName, 'public');
        $tipeFile = $file->extension();
    } elseif ($request->filled('file_url')) {
        $path = $request->file_url;
        $originalName = basename($request->file_url);
        $tipeFile = pathinfo($originalName, PATHINFO_EXTENSION);
    }

    $publikasi->update([
        'id_kategori' => $request->id_kategori,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'file_path' => $path,
        'original_name' => $originalName,
        'tipe_file' => $tipeFile,
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

    // Cek apakah file_path adalah URL (link)
    if (filter_var($publikasi->file_path, FILTER_VALIDATE_URL)) {
       
        return redirect()->away($publikasi->file_path);
    }

    // Kalau bukan URL, berarti file lokal di storage

    $path = storage_path('app/public/' . $publikasi->file_path);

    if (!file_exists($path)) {
        return redirect()->back()->with('error', 'File tidak ditemukan di server.');
    }

    return response()->download($path, $publikasi->original_name);
}




}


