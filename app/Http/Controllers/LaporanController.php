<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPeminjaman.alat']);

        // Filter Rentang Tanggal
        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_awal, $request->tgl_akhir]);
        }
        // Filter Per User
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        // Filter Per Alat (Menggunakan relasi detail_peminjaman)
        if ($request->alat_id) {
            $query->whereHas('detailPeminjaman', function ($q) use ($request) {
                $q->where('alat_id', $request->alat_id);
            });
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        // Data untuk Dropdown Filter
        $users = \App\Models\User::where('role', 'user')->get();
        $alats = \App\Models\AlatRiset::all();

        return view('laporan.index', compact('peminjaman', 'users', 'alats'));
    }
}
