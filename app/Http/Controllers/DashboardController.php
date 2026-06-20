<?php

namespace App\Http\Controllers;

use App\Models\AlatRiset;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB TAMBAHKAN INI
use Carbon\Carbon; // WAJIB TAMBAHKAN INI

class DashboardController extends Controller
{
    public function index()
    {
        $userRole = auth()->user()->role;

        // Tampilan untuk Admin DAN Operator
        if (in_array($userRole, ['admin', 'operator'])) {
            $totalAlat = AlatRiset::sum('stok');
            $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
            $totalUser = User::where('role', 'user')->count();
            $statusPending = Peminjaman::where('status', 'pending')->count();
            $statusSelesai = Peminjaman::where('status', 'selesai')->count();

            // Logic Analitik: Top 5 Alat Sering Dipinjam Minggu Ini
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $topAlat = DB::table('detail_peminjaman')
                ->join('peminjaman', 'detail_peminjaman.peminjaman_id', '=', 'peminjaman.id')
                ->join('alat_riset', 'detail_peminjaman.alat_id', '=', 'alat_riset.id')
                ->whereBetween('peminjaman.tanggal_pinjam', [$startOfWeek, $endOfWeek])
                ->select('alat_riset.nama_alat', DB::raw('SUM(detail_peminjaman.jumlah_pinjam) as total_dipinjam'))
                ->groupBy('alat_riset.id', 'alat_riset.nama_alat')
                ->orderByDesc('total_dipinjam')
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'totalAlat',
                'sedangDipinjam',
                'totalUser',
                'statusPending',
                'statusSelesai',
                'topAlat'
            ));
        } else {
            // Tampilan Khusus untuk Peminjam / Peneliti
            $pinjamanAktif = Peminjaman::where('user_id', auth()->id())->where('status', 'dipinjam')->count();
            $pinjamanSelesai = Peminjaman::where('user_id', auth()->id())->where('status', 'selesai')->count();

            return view('dashboard', compact('pinjamanAktif', 'pinjamanSelesai'));
        }
    }
}
