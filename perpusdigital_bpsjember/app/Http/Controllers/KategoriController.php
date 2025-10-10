<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan semua kategori.
     */
    public function index()
    {
        $kategori = Kategori::paginate(10);
        return view('kategori.kategori', compact('kategori'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('kategori.addkategori');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        Kategori::create($request->all());
        return redirect()->route('kategori.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.editkategori', compact('kategori'));
    }

    /**
     * Update data kategori.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori->update($request->all());
        return redirect()->route('kategori.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
