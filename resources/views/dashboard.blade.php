@extends('layouts.admin')

@section('title', 'Dashboard - Lab Riset')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Dashboard Utama</h2>
        </div>

        @if (in_array(auth()->user()->role, ['admin', 'operator']))
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white shadow border-0">
                    <div class="card-body">
                        <h5>Total Stok Alat Lab</h5>
                        <h3>{{ $totalAlat }} Unit</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-dark shadow border-0">
                    <div class="card-body">
                        <h5>Transaksi Aktif (Dipinjam)</h5>
                        <h3>{{ $sedangDipinjam }} Transaksi</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white shadow border-0">
                    <div class="card-body">
                        <h5>Total Mahasiswa/Peneliti</h5>
                        <h3>{{ $totalUser }} Orang</h3>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-7 mb-4">
                        <div class="card shadow border-0 h-100">
                            <div class="card-header py-3 bg-white">
                                <h6 class="m-0 font-weight-bold text-primary">Grafik Status Transaksi</h6>
                            </div>
                            <div class="card-body d-flex align-items-center">
                                <canvas id="transaksiChart" width="400" height="150"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 mb-4">
                        <div class="card shadow border-0 h-100">
                            <div class="card-header py-3 bg-info text-white">
                                <h6 class="m-0 font-weight-bold">Alat Terbanyak Dipinjam Minggu ini</h6>
                            </div>
                            <div class="card-body p-0">
                                @if (count($topAlat) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach ($topAlat as $index => $alat)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <div>
                                                    <span class="badge bg-secondary me-2">#{{ $index + 1 }}</span>
                                                    <span class="fw-bold">{{ $alat->nama_alat }}</span>
                                                </div>
                                                <span
                                                    class="badge bg-primary rounded-pill px-3 py-2">{{ $alat->total_dipinjam }}x
                                                    Dipinjam</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center text-muted p-5">
                                        <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                                        <p class="mb-0">Belum ada data peminjaman di minggu ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 mb-4">
                <div class="card bg-warning text-dark shadow border-0">
                    <div class="card-body">
                        <h5>Alat Sedang Dipinjam</h5>
                        <h3>{{ $pinjamanAktif }} Transaksi</h3>
                        <p class="mb-0 text-sm">Pastikan untuk mengembalikan alat sebelum tanggal tenggat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card bg-success text-white shadow border-0">
                    <div class="card-body">
                        <h5>Riwayat Selesai</h5>
                        <h3>{{ $pinjamanSelesai }} Transaksi</h3>
                        <p class="mb-0 text-sm">Terima kasih telah menjaga fasilitas laboratorium dengan baik.</p>
                    </div>
                </div>
            </div>
        @endif

    </div>

    @if (in_array(auth()->user()->role, ['admin', 'operator']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('transaksiChart').getContext('2d');
            var transaksiChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [, 'Sedang Dipinjam', 'Selesai'],
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: [{{ $statusPending ?? 0 }}, {{ $sedangDipinjam }}, {{ $statusSelesai ?? 0 }}],
                        backgroundColor: ['#6c757d', '#ffc107', '#198754']
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
