<!DOCTYPE html>
    <html lang="en">
    <head>
    <style>
        .sidebar {
        display: flex;
        flex-direction: column;
        height: 100%;
        }
    
        .sidebar-logout {
        margin-top: auto;
        
        }
    </style>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    </head>
    <body>
    <div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
            role="menu" data-accordion="false">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Data Pengguna -->
            <li class="nav-header">Data Pengguna</li>

            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>

            <!-- Data Barang -->
            <li class="nav-header">Data Barang</li>

            <li class="nav-item">
                <a href="{{ url('/katagori') }}" class="nav-link {{ ($activeMenu == 'katagori') ? 'active' : '' }}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Katagori Barang</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Data Barang</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/suplier')}}" class="nav-link {{ ($activeMenu == 'suplier') ? 'active' : ''}}">
                <i class="nav-icon fas fa-truck"></i>
                <p>Suplier </p>
                </a>
            </li>
            <!-- Data Transaksi -->
            <li class="nav-header">Data Transaksi</li>

            <li class="nav-item">
                <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Stok Barang</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Transaksi Penjualan</p>
                </a>
            </li>

        </ul>
    </nav>
</div>
    <!-- Tombol Logout Selalu di Bawah -->
    <div class="sidebar-logout mt-auto p-3">
    <a href="{{ url('logout') }}" class="btn btn-danger btn-block"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </a>
    <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
        @csrf
    </form>
    </div>
    </body>
    </html> 
    </div>