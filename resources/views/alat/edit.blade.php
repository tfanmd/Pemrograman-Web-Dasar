@extends('layouts.admin')

@section('title', 'Edit Alat')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Alat</h6>
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

            <form action="{{ route('alat.update', $alat->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori Alat</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="" disabled>-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $alat->kategori_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_alat" class="form-label">Nama Alat</label>
                    <input type="text" class="form-control" id="nama_alat" name="nama_alat" value="{{ $alat->nama_alat }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="{{ $alat->stok }}" min="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kondisi" class="form-label">Kondisi Saat Ini</label>
                        <select class="form-select" id="kondisi" name="kondisi" required>
                            <option value="Baik" {{ $alat->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $alat->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $alat->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">Update Data</button>
                <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection