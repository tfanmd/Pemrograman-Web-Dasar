<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AlatRiset;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            // Data untuk Admin
            $totalAlat = AlatRiset::sum('stok');
            $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
            $totalUser = User::where('role', 'user')->count();
            $statusPending = Peminjaman::where('status', 'pending')->count();
            $statusSelesai = Peminjaman::where('status', 'selesai')->count();

            return view('dashboard', compact('totalAlat', 'sedangDipinjam', 'totalUser', 'statusPending', 'statusSelesai'));
        } else {
            // Data untuk User Biasa
            $pinjamanAktif = Peminjaman::where('user_id', auth()->id())->where('status', 'dipinjam')->count();
            $pinjamanSelesai = Peminjaman::where('user_id', auth()->id())->where('status', 'selesai')->count();

            return view('dashboard', compact('pinjamanAktif', 'pinjamanSelesai'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
