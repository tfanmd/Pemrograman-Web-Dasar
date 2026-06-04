@extends('layouts.admin')

@section('title', 'Dashboard - Lab Riset')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Dashboard Utama</h2>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5>Total Stok Alat Lab</h5>
                <h3>{{ $totalAlat }} Unit</h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-dark shadow">
            <div class="card-body">
                <h5>Transaksi Aktif (Dipinjam)</h5>
                <h3>{{ $sedangDipinjam }} Transaksi</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5>Total Mahasiswa/Peneliti</h5>
                <h3>{{ $totalUser }} Orang</h3>
            </div>
        </div>
    </div>
    
</div>

@endsection