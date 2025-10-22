<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PublikasiController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $query = Publikasi::with('kategori');

        } elseif ($user->hasRole('operator')) {
            $query = Publikasi::with('kategori')
                ->where('uploaded_by', $user->id)
                ->whereIn('status', ['tertunda', 'diterima']);

        } else {
            $query = Publikasi::with('kategori')
                ->where('status', 'diterima');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $publikasi = $query->latest()->paginate(10);

        return view('publikasi.publikasi', compact('publikasi'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('publikasi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'file_publikasi' => 'nullable|mimes:pdf,epub,docx,xlsx,xls,png,jpg,jpeg,mp4|max:20480',
            'file_url' => 'nullable|url',
        ]);


        if (!$request->hasFile('file_publikasi') && !$request->filled('file_url')) {
            return back()
                ->withErrors(['file_publikasi' => 'Harap unggah file atau isi link publikasi.'])
                ->withInput();
        }

        $path = null;
        $originalName = null;
        $tipeFile = null;

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


    public function edit(Publikasi $publikasi)
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('publikasi.editpublikasi', compact('publikasi', 'kategoris'));
    }

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


    public function destroy(Publikasi $publikasi)
    {
        Storage::disk('public')->delete($publikasi->file_path);
        $publikasi->delete();
        return redirect()->route('publikasi.publikasi')->with('success', 'Publikasi berhasil dihapus.');
    }


    public function show($id)
    {
        $publikasi = Publikasi::with('kategori')->findOrFail($id);
        return view('publikasi.detailpublikasi', compact('publikasi'));
    }

    public function unduh($id)
    {
        $publikasi = Publikasi::findOrFail($id);

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


    public function validasi(Request $request, $id)
    {
        $publikasi = Publikasi::findOrFail($id);

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $publikasi->update([
            'status' => $request->status,
        ], [
            'timestamps' => false
        ]);

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

    public function publikasipengguna(Request $request,$kategori)
{
    // Cari ID kategori dari tabel kategori
    $kategoriModel = \App\Models\Kategori::whereRaw('LOWER(nama_kategori) = ?', [strtolower($kategori)])->firstOrFail();

    $query = \App\Models\Publikasi::with('kategori')
            ->where('id_kategori', $kategoriModel->id)
            ->where('status', 'diterima');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $publikasi = $query->latest()->get();

    return view('publikasi.publikasipengguna', compact('publikasi', 'kategori'));
}

public function detailPengguna($id)
{
    $publikasi = \App\Models\Publikasi::with('kategori')->findOrFail($id);
    return view('publikasi.detailpublikasipengguna', compact('publikasi'));
}

}
