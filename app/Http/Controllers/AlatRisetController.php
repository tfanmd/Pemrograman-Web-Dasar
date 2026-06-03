<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AlatRiset;

use App\Models\KategoriAlat;

class AlatRisetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = AlatRiset::with('kategori')->get();
        return view('alat.index', compact('alat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriAlat::all();
        return view('alat.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string'
        ]);

        AlatRiset::create($request->all());

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil ditambahkan!');
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
        $alat = AlatRiset::findOrFail($id);
        $kategori = KategoriAlat::all();
        return view('alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string'
        ]);

        $alat = AlatRiset::findOrFail($id);
        $alat->update($request->all());

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alat = AlatRiset::findOrFail($id);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil dihapus!');
    }
}
