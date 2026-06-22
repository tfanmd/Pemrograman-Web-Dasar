@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<style>
    @media print {
        nav, .navbar, .sidebar, .btn, footer, hr {
            display: none !important;
        }
        .container-fluid, .card, .card-body {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        body {
            background-color: #fff !important;
            color: #000 !important;
            font-size: 12pt;
        }

        .print-header {
            display: block !important;
            text-center: center;
            margin-bottom: 30px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }

        .print-footer {
            display: block !important;
            margin-top: 50px;
        }
    }

    .print-header, .print-footer {
        display: none;
    }
</style>

<div class="print-header text-center">
    <h3 class="mb-1" style="text-transform: uppercase; font-weight: bold;">Universitas Budi Luhur</h3>
    <h4 class="mb-1">Laboratorium Pusat & Riset Teknologi</h4>
    <p class="mb-0" style="font-size: 10pt; font-style: italic;">Jl. Ciledug Raya, Petukangan Utara, Pesanggrahan, Jakarta Selatan</p>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Peminjaman</h6>
        <button type="button" onclick="window.print()" class="btn btn-success btn-sm">
            <i class="fas fa-print"></i> Cetak Bukti PDF
        </button>
    </div>
    <div class="card-body">
        
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="text-secondary mb-3" style="font-weight: bold;">Data Peminjaman</h5>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="35%" class="fw-bold">Nama Peminjam</td>
                        <td width="5%">:</td>
                        <td>{{ $peminjaman->user->name ?? 'Tidak Diketahui' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Pinjam</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Tenggat</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_tenggat)->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status Transaksi</td>
                        <td>:</td>
                        <td>
                            @if ($peminjaman->status == 'dipinjam')
                                <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                            @else
                                <span class="badge bg-success">Selesai (Dikembalikan)</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h5 class="text-secondary mb-3" style="font-weight: bold;">Daftar Alat Komponen</h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Alat Riset</th>
                        <th width="20%">Kondisi Alat</th>
                        <th width="15%" class="text-center">Jumlah Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman->detailPeminjaman as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->alat->nama_alat ?? 'Alat Telah Dihapus' }}</td>
                            <td>{{ $detail->alat->kondisi ?? '-' }}</td>
                            <td class="text-center fw-bold">{{ $detail->jumlah_pinjam }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada rincian alat di transaksi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="print-footer">
            <div class="row justify-content-between text-center">
                <div class="col-4">
                    <p class="mb-5">Peminjam / Peneliti,</p>
                    <p class="fw-bold text-decoration-underline">{{ $peminjaman->user->name ?? '.......................' }}</p>
                </div>
                <div class="col-4">
                    <p class="mb-5">Petugas Lab (Operator),</p>
                    <p class="fw-bold text-decoration-underline">{{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary px-4">Kembali</a>
        </div>

    </div>
</div>
@endsection