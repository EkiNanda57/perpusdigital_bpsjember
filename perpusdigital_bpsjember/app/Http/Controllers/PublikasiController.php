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
            'file_publikasi' => 'required|file|mimes:pdf,epub,docx|max:10240',
        ]);

        $path = $request->file('file_publikasi')->store('publikasi', 'public');

        Publikasi::create([
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
            'tipe_file' => $request->file('file_publikasi')->extension(),
            'status' => 'tertunda', // otomatis tertunda saat baru diupload
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('publikasi.publikasi')->with('success', 'Publikasi berhasil ditambahkan dan menunggu persetujuan admin.');
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
            'id_kategori' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'file_publikasi' => 'nullable|file|mimes:pdf,epub,docx|max:10240',
            'status' => 'required|in:tertunda,diterima,ditolak',
        ]);

        $path = $publikasi->file_path;
        if ($request->hasFile('file_publikasi')) {
            Storage::disk('public')->delete($publikasi->file_path);
            $path = $request->file('file_publikasi')->store('publikasi', 'public');
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
        $filePath = storage_path('app/public/' . $publikasi->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'File tidak ditemukan.');
        }
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
}
