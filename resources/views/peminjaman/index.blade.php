@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Peminjaman</h6>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('laporan.index') }}" class="btn btn-info btn-sm text-white me-2"><i class="fas fa-print"></i>
                    Laporan</a>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">Buat Transaksi</a>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>

                            @if (auth()->user()->role === 'admin')
                                <th>Peminjam (User)</th>
                            @endif

                            <th>Tanggal Pinjam</th>
                            <th>Tenggat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                @if (auth()->user()->role === 'admin')
                                    <td>{{ $item->user->name ?? 'User Tidak Diketahui' }}</td>
                                @endif

                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-M-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_tenggat)->format('d-M-Y') }}</td>
                                <td>
                                    @if ($item->status == 'dipinjam')
                                        <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                    @elseif($item->status == 'selesai')
                                        <span class="badge bg-success">Selesai (Dikembalikan)</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('peminjaman.show', $item->id) }}"
                                            class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>

                                        @if (auth()->user()->role === 'admin' && $item->status == 'dipinjam')
                                            <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menyelesaikan transaksi ini? Stok alat akan dikembalikan.');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Selesaikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
