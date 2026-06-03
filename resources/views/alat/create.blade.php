@extends('layouts.admin')

@section('title', 'Tambah Alat Riset')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Alat Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('alat.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori Alat</label>
                <select class="form-select" id="kategori_id" name="kategori_id" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_alat" class="form-label">Nama Alat</label>
                <input type="text" class="form-control" id="nama_alat" name="nama_alat" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stok" class="form-label">Jumlah Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kondisi" class="form-label">Kondisi Saat Ini</label>
                    <select class="form-select" id="kondisi" name="kondisi" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">Simpan Data</button>
            <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection