<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Lab')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="d-flex">
        <nav class="bg-dark text-white p-3 vh-100" style="width: 250px;">
            <h4>Lab Riset</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link text-white"><i class="fas fa-home me-2"></i> Dashboard</a>
                </li>
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item mt-3">
                        <small class="text-secondary">MASTER DATA</small>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}" class="nav-link text-white"><i
                                class="fas fa-tags me-2"></i> Kategori Alat</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('alat.index') }}" class="nav-link text-white"><i
                                class="fas fa-microscope me-2"></i> Alat Riset</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link text-white"><i
                                class="fas fa-users me-2"></i>Data  User</a>
                    </li>
                @endif

                <li class="nav-item mt-3">
                    <small class="text-secondary">TRANSAKSI</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('peminjaman.index') }}" class="nav-link text-white"><i
                            class="fas fa-handshake me-2"></i> Peminjaman</a>
                </li>
            </ul>
        </nav>

        <div class="flex-grow-1 bg-light">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3">Halo, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Logout</button>
                    </form>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
