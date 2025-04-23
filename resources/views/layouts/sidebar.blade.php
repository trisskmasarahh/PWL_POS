<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .sidebar-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
        }

        .sidebar {
            padding: 10px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-logout {
            padding: 20px;
        }

        .nav-link {
            color: white;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #007bff;
            border-radius: 5px;
        }

        .nav-icon {
            margin-right: 10px;
        }

        .nav-header {
            padding: 10px 12px;
            font-size: 0.9rem;
            font-weight: bold;
            color: #c2c7d0;
            text-transform: uppercase;
        }

        .form-inline {
            padding: 10px;
        }

        .form-control {
            width: 100%;
            padding: 5px;
        }

        .btn-sidebar {
            background: none;
            border: none;
            color: white;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<div class="sidebar-container">

    <!-- Sidebar content -->
    <div class="sidebar">
        <!-- Search -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn-sidebar">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column">

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Data Pengguna</li>

                <li class="nav-item">
                    <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i><p>Level User</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                        <i class="nav-icon far fa-user"></i><p>Data User</p>
                    </a>
                </li>

                <li class="nav-header">Data Barang</li>

                <li class="nav-item">
                    <a href="{{ url('/katagori') }}" class="nav-link {{ ($activeMenu == 'katagori') ? 'active' : '' }}">
                        <i class="nav-icon far fa-bookmark"></i><p>Katagori Barang</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                        <i class="nav-icon far fa-list-alt"></i><p>Data Barang</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/suplier') }}" class="nav-link {{ ($activeMenu == 'suplier') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i><p>Suplier</p>
                    </a>
                </li>

                <li class="nav-header">Data Transaksi</li>

                <li class="nav-item">
                    <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i><p>Stok Barang</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i><p>Transaksi Penjualan</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    <!-- Logout di paling bawah -->
    <div class="sidebar-logout">
        <a href="{{ url('logout') }}" class="btn btn-danger btn-block"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
            @csrf
        </form>
    </div>

</div>

</body>
</html>
