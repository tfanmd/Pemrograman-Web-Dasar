<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\AlatRiset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (in_array(auth()->user()->role, ['admin', 'operator'])) {
            $peminjaman = Peminjaman::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $peminjaman = Peminjaman::where('user_id', auth()->id())->with('user')->orderBy('created_at', 'desc')->get();
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang diizinkan membuat transaksi.');
        }

        $users = User::where('role', 'user')->get();
        $alat = AlatRiset::where('stok', '>', 0)->get();

        return view('peminjaman.create', compact('users', 'alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'operator'])) {
            abort(403, 'Hanya Admin dan Operator yang diizinkan memproses transaksi.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_tenggat' => 'required|date|after_or_equal:tanggal_pinjam',
            'alat_id' => 'required|exists:alat_riset,id',
            'jumlah_pinjam' => 'required|integer|min:1'
        ]);

        // Cek stok alat terlebih dahulu
        $alat = AlatRiset::findOrFail($request->alat_id);
        if ($request->jumlah_pinjam > $alat->stok) {
            return back()->withErrors(['jumlah_pinjam' => 'Stok alat tidak mencukupi! Sisa stok: ' . $alat->stok]);
        }

        // Gunakan DB Transaction agar jika salah satu gagal, semuanya batal (Rollback)
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel peminjaman (Tabel Transaksi 1)
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_tenggat' => $request->tanggal_tenggat,
                'status' => 'dipinjam' // Status awal
            ]);

            // 2. Simpan ke tabel detail_peminjaman (Tabel Transaksi 2)
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $request->alat_id,
                'jumlah_pinjam' => $request->jumlah_pinjam
            ]);

            // 3. Kurangi stok di tabel master alat_riset
            $alat->stok -= $request->jumlah_pinjam;
            $alat->save();

            DB::commit(); // Simpan permanen ke database

            return redirect()->route('peminjaman.index')->with('success', 'Transaksi peminjaman berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua proses jika ada error
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])->findOrFail($id);
        if (auth()->user()->role !== 'admin' && $peminjaman->user_id !== auth()->id()) {
            abort(403); // Forbidden jika bukan admin dan bukan pemilik transaksi
        }
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function kembalikan($id)
    {
        // Pastikan hanya admin yang bisa melakukan ini
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $peminjaman = Peminjaman::with('detailPeminjaman')->findOrFail($id);

        if ($peminjaman->status === 'selesai') {
            return back()->with('error', 'Transaksi ini sudah diselesaikan sebelumnya.');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // 1. Ubah status peminjaman menjadi selesai
            $peminjaman->update(['status' => 'selesai']);

            // 2. Kembalikan stok untuk setiap alat yang dipinjam
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = \App\Models\AlatRiset::find($detail->alat_id);
                if ($alat) {
                    $alat->stok += $detail->jumlah_pinjam;
                    $alat->save();
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', 'Peminjaman diselesaikan! Stok alat telah dikembalikan.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
