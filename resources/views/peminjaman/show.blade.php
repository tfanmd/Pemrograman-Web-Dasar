@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Peminjaman</h6>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="35%">Nama Peminjam</th>
                            <td width="5%">:</td>
                            <td><strong>{{ $peminjaman->user->name ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Tenggat</th>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_tenggat)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:</td>
                            <td>
                                @if ($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                @elseif($peminjaman->status == 'selesai')
                                    <span class="badge bg-success">Selesai (Dikembalikan)</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>
            <h6 class="font-weight-bold mb-3">Daftar Alat yang Dipinjam</h6>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Alat / Barang</th>
                            <th width="15%">Jumlah Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman->detailPeminjaman as $detail)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</td>
                                <td class="text-center">{{ $detail->jumlah_pinjam }} Unit</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
