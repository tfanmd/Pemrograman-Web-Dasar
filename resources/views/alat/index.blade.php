@extends('layouts.admin')

@section('title', 'Data Alat Riset')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Alat Laboratorium</h6>
        <a href="{{ route('alat.create') }}" class="btn btn-primary btn-sm">Tambah Alat</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Alat</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                        <td>{{ $item->nama_alat }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            @if($item->kondisi == 'Baik')
                                <span class="badge bg-success">Baik</span>
                            @else
                                <span class="badge bg-danger">{{ $item->kondisi }}</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('alat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus alat ini?');">
                                <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection