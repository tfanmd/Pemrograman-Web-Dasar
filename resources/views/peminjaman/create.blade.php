@extends('layouts.admin')

@section('title', 'Buat Transaksi Peminjaman')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Catat Peminjaman Multi-Alat</h6>
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
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Peminjam (User/Mahasiswa)</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            @foreach ($users as $usr)
                                <option value="{{ $usr->id }}">{{ $usr->name }} ({{ ucfirst($usr->role) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tanggal Tenggat Kembali</label>
                        <input type="date" name="tanggal_tenggat" class="form-control"
                            value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-secondary">Daftar Alat Yang Dipinjam</h5>
                    <button type="button" id="btn-tambah-alat" class="btn btn-info btn-sm text-white">
                        <i class="fas fa-plus"></i> Tambah Alat
                    </button>
                </div>

                <div id="wrapper-alat">
                    <div class="row row-alat align-items-end mb-3">
                        <div class="col-md-7">
                            <label class="form-label">Pilih Alat Riset</label>
                            <select name="alat_id[]" class="form-select" required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach ($alats as $alt)
                                    <option value="{{ $alt->id }}">
                                        {{ $alt->nama_alat }} (Stok: {{ $alt->stok }} | Kondisi: {{ $alt->kondisi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah_pinjam[]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger w-100 btn-hapus-baris" disabled>Hapus</button>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Simpan Transaksi</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btn-tambah-alat').addEventListener('click', function() {
            let wrapper = document.getElementById('wrapper-alat');
            let barisBaru = wrapper.querySelector('.row-alat').cloneNode(true);

            barisBaru.querySelector('select').value = "";
            barisBaru.querySelector('input').value = "";

            let btnHapus = barisBaru.querySelector('.btn-hapus-baris');
            btnHapus.removeAttribute('disabled');

            btnHapus.addEventListener('click', function() {
                barisBaru.remove();
            });

            wrapper.appendChild(barisBaru);
        });

        document.getElementById('wrapper-alat').addEventListener('change', function(e) {
            if (e.target && e.target.matches('select[name="alat_id[]"]')) {
                let currentSelect = e.target;
                let allSelects = document.querySelectorAll('select[name="alat_id[]"]');
                let nilaiDuplikat = false;

                allSelects.forEach(function(select) {
                    if (select !== currentSelect && select.value === currentSelect.value && currentSelect
                        .value !== "") {
                        nilaiDuplikat = true;
                    }
                });

                if (nilaiDuplikat) {
                    alert(
                        '⚠️ Alat ini sudah dipilih di baris lain! Silakan pilih alat yang berbeda atau sesuaikan jumlahnya.'
                        );
                    currentSelect.value = ""; 
                }
            }
        });
    </script>
@endsection
