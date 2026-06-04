<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input tanggal dari form (jika ada)
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');

        // Jika user melakukan filter
        if ($tglAwal && $tglAkhir) {
            $peminjaman = Peminjaman::with('user')
                ->whereBetween('tanggal_pinjam', [$tglAwal, $tglAkhir])
                ->orderBy('tanggal_pinjam', 'asc')
                ->get();
        } else {
            // Default: Tampilkan data bulan ini
            $peminjaman = Peminjaman::with('user')
                ->whereMonth('tanggal_pinjam', date('m'))
                ->orderBy('tanggal_pinjam', 'asc')
                ->get();
        }

        return view('laporan.index', compact('peminjaman', 'tglAwal', 'tglAkhir'));
    }
}
