@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data User</h6>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hak Akses (Role)</label>
                    <select class="form-select" name="role" required>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru <small class="text-danger">(Kosongkan jika tidak ingin ganti
                            password)</small></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <button type="submit" class="btn btn-warning">Update Data</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
