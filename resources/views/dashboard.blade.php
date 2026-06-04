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
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Status Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="transaksiChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('transaksiChart').getContext('2d');
            var transaksiChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pending', 'Sedang Dipinjam', 'Selesai'],
                    datasets: [{
                        data: [{{ $statusPending ?? 0 }}, {{ $sedangDipinjam }}, {{ $statusSelesai ?? 0 }}],
                        backgroundColor: ['#6c757d', '#ffc107', '#198754']
                    }]
                }
            });
        </script>
    </div>

@endsection
