@extends('layouts.admin')

@section('title', 'Dashboard - Lab Riset')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Dashboard Utama</h2>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5>Total Alat</h5>
                <h3>150</h3> </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5>Sedang Dipinjam</h5>
                <h3>12</h3>
            </div>
        </div>
    </div>
</div>
@endsection