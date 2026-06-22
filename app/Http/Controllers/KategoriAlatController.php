<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriAlat;
use App\Models\AlatRiset;
use App\Models\DetailPeminjaman;    

class KategoriAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriAlat::all();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        // Simpan ke database
        KategoriAlat::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = KategoriAlat::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = KategoriAlat::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriAlat::findOrFail($id);

        $adaAlat = AlatRiset::where('kategori_id', $id)->exists();

        if ($adaAlat) {
            return redirect()->route('kategori.index')->with('error', "Gagal menghapus! Kategori '{$kategori->nama_kategori}' masih digunakan oleh beberapa data alat riset.");
        }

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Data Kategori berhasil dihapus.');
    }
}
