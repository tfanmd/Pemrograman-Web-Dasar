<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Lab')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS untuk transisi sidebar */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        .nav-link i {
            width: 25px;
            text-align: center;
        }

        @media print {

            nav,
            .navbar,
            form,
            button,
            a.btn {
                display: none !important;
            }

            .flex-grow-1 {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex overflow-hidden vh-100">
        <nav id="sidebar" class="bg-dark text-white p-3 overflow-auto">
            <h5 class="text-center mt-2 mb-3">Lab Riset</h5>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white"><i class="fas fa-home me-2"></i>
                        Dashboard</a>
                </li>

                @if (in_array(auth()->user()->role, ['admin', 'operator']))
                    <li class="nav-item mt-3"><small class="text-secondary fw-bold px-3">MASTER DATA</small></li>

                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item"><a href="{{ route('kategori.index') }}" class="nav-link text-white"><i
                                    class="fas fa-tags me-2"></i> Kategori Alat</a></li>
                        <li class="nav-item"><a href="{{ route('alat.index') }}" class="nav-link text-white"><i
                                    class="fas fa-microscope me-2"></i> Alat Riset</a></li>
                    @endif

                    <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link text-white"><i
                                class="fas fa-users me-2"></i> Data User</a></li>
                @endif

                <li class="nav-item mt-3"><small class="text-secondary fw-bold px-3">TRANSAKSI</small></li>
                <li class="nav-item"><a href="{{ route('peminjaman.index') }}" class="nav-link text-white"><i
                            class="fas fa-handshake me-2"></i> Peminjaman</a></li>

                @if (in_array(auth()->user()->role, ['admin', 'operator']))
                    <li class="nav-item"><a href="{{ route('laporan.index') }}" class="nav-link text-white"><i
                                class="fas fa-file-pdf me-2"></i> Laporan Peminjaman</a></li>
                @endif
            </ul>
        </nav>

        <div class="flex-grow-1 bg-light overflow-auto">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
                <button id="sidebarToggle" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 fw-bold">Halo, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-sign-out-alt"></i>
                            Logout</button>
                    </form>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });
    </script>
</body>

</html>
