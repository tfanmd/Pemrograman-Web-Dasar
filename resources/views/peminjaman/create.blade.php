@extends('layouts.admin')

@section('title', 'Buat Transaksi Peminjaman')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Transaksi Peminjaman</h6>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="row">
                    @if (auth()->user()->role === 'admin')
                        <div class="col-md-12 mb-3">
                            <label for="user_id" class="form-label">Pilih Peminjam (User)</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="" disabled selected>-- Pilih Mahasiswa/Peneliti --</option>
                                @foreach ($users as $usr)
                                    <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_tenggat" class="form-label">Tanggal Tenggat (Kembali)</label>
                        <input type="date" class="form-control" id="tanggal_tenggat" name="tanggal_tenggat" required>
                    </div>
                </div>

                <hr>
                <h6 class="font-weight-bold mb-3">Pilih Alat Riset</h6>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="alat_id" class="form-label">Nama Alat</label>
                        <select class="form-select" id="alat_id" name="alat_id" required>
                            <option value="" disabled selected>-- Pilih Alat (Stok Tersedia) --</option>
                            @foreach ($alat as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_alat }} (Sisa Stok: {{ $item->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jumlah_pinjam" class="form-label">Jumlah Pinjam</label>
                        <input type="number" class="form-control" id="jumlah_pinjam" name="jumlah_pinjam" min="1"
                            value="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Simpan Transaksi</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
@endsection
