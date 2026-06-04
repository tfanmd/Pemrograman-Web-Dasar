@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Peminjaman Alat</h6>
    </div>
    <div class="card-body">
        
        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tgl_awal" class="form-control" value="{{ $tglAwal ?? '' }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control" value="{{ $tglAkhir ?? '' }}" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter Data</button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" onclick="window.print()" class="btn btn-success">Cetak PDF</button>
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