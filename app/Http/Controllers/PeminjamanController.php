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
        if (!in_array(auth()->user()->role, ['admin', 'operator'])) {
            abort(403, 'Akses ditolak.');
        }

        $users = User::where('role', 'user')->get();
        $alats = AlatRiset::where('stok', '>', 0)->get(); // Hanya alat yang stoknya ready

        return view('peminjaman.create', compact('users', 'alats'));
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
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'required|exists:alat_riset,id',
            'jumlah_pinjam' => 'required|array|min:1',
            'jumlah_pinjam.*' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan data induk ke tabel peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_tenggat' => $request->tanggal_tenggat,
                'status' => 'dipinjam'
            ]);

            // 2. Lakukan perulangan array untuk memproses masing-masing alat riset
            foreach ($request->alat_id as $index => $alatId) {
                $jumlahPinjam = $request->jumlah_pinjam[$index];
                $alat = AlatRiset::findOrFail($alatId);

                // Cek ketersediaan stok masing-masing komponen alat
                if ($jumlahPinjam > $alat->stok) {
                    DB::rollBack();
                    return back()->withInput()->withErrors([
                        'error' => "Stok alat '{$alat->nama_alat}' tidak mencukupi! Diminta: {$jumlahPinjam}, Sisa stok: {$alat->stok}"
                    ]);
                }

                // Simpan detail data ke tabel detail_peminjaman
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alatId,
                    'jumlah_pinjam' => $jumlahPinjam
                ]);

                // Potong stok alat terkait
                $alat->stok -= $jumlahPinjam;
                $alat->save();
            }

            DB::commit(); // Transaksi sukses, kunci perubahan ke database

            return redirect()->route('peminjaman.index')->with('success', 'Transaksi peminjaman beberapa alat berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack(); // Gagalkan semua pemotongan stok jika ada error sistem crash
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
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
        if (!in_array(auth()->user()->role, ['admin', 'operator'])) {
            abort(403, 'Akses ditolak.');
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

            if ($peminjaman->status === 'selesai') {
                return back()->withErrors(['error' => 'Transaksi ini sudah selesai sebelumnya.']);
            }

            // Lakukan looping untuk mengembalikan stok seluruh barang yang dipinjam di transaksi ini
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = $detail->alat;
                if ($alat) {
                    $alat->stok += $detail->jumlah_pinjam; 
                    $alat->save();
                }
            }

            $peminjaman->status = 'selesai';
            $peminjaman->save();

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Seluruh alat telah dikembalikan dan stok diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyelesaikan transaksi: ' . $e->getMessage()]);
        }
    }
}
