@extends('layouts.admin')

@section('title', 'Data Alat Riset')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Alat Laboratorium</h6>
            <a href="{{ route('alat.create') }}" class="btn btn-primary btn-sm">Tambah Alat</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Nama Alat</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->gambar_alat)
                                        <img src="{{ asset('storage/' . $item->gambar_alat) }}" item="Gambar"
                                            class="img-thumbnail" width="80" style="object-fit: cover; height: 80px;">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                <td>{{ $item->nama_alat }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    @if ($item->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->kondisi }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('alat.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm me-2">Edit</a>

                                        <form action="{{ route('alat.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus alat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
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
