<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman;
use App\Http\Controllers\PeminjamanController;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user,operator',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'Data User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, tapi abaikan email milik user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika form password diisi, berarti admin ingin mereset password user ini
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data User berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('user.index')->with('error', "⚠️ Gagal menghapus! Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.");
        }

        $user = User::findOrFail($id);

        // Cek apakah user ini memiliki riwayat peminjaman alat
        $adaTransaksi = Peminjaman::where('user_id', $id)->exists();

        if ($adaTransaksi) {
            return redirect()->route('user.index')->with('error', "Gagal menghapus! Akun '{$user->name}' tidak bisa dihapus karena memiliki riwayat transaksi peminjaman di laboratorium.");
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data User berhasil dihapus.');
    }
}
