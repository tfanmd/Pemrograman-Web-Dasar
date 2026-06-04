@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')

    <style>
        @media print {

            /* Sembunyikan elemen yang gak perlu dicetak */
            nav,
            .navbar,
            form,
            button,
            a.btn {
                display: none !important;
            }

            /* Pastikan area konten mengambil lebar penuh saat dicetak */
            .flex-grow-1 {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Peminjaman Alat</h6>
        </div>
        <div class="card-body">

            <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">Tgl Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tgl Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter User</label>
                        <select name="user_id" class="form-select">
                            <option value="">Semua User</option>
                            @foreach ($users as $usr)
                                <option value="{{ $usr->id }}" {{ request('user_id') == $usr->id ? 'selected' : '' }}>
                                    {{ $usr->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter Alat</label>
                        <select name="alat_id" class="form-select">
                            <option value="">Semua Alat</option>
                            @foreach ($alats as $alt)
                                <option value="{{ $alt->id }}" {{ request('alat_id') == $alt->id ? 'selected' : '' }}>
                                    {{ $alt->nama_alat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button type="submit" class="btn btn-primary w-100 mb-1">Filter</button>
                        <button type="button" onclick="window.print()" class="btn btn-success w-100">Cetak</button>
                    </div>
                </div>
            </form>

            <hr>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Tenggat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->tanggal_pinjam }}</td>
                                <td>{{ $item->tanggal_tenggat }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
