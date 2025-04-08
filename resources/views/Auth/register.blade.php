    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    
    <style>
        .register-box {
        width: 420px;
        }
        .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .text-danger {
        font-size: 0.85rem;
        }
    </style>
    </head>
    <body class="hold-transition login-page bg-light">
    <div class="register-box">
    <div class="card card-outline card-primary shadow">
        <div class="card-header text-center">
        <a href="{{ url('/') }}" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
        <p class="login-box-msg text-muted">Daftar akun baru untuk melanjutkan</p>
    
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif
    
        <form action="{{ url('register') }}" method="POST">
            @csrf
    
            <div class="input-group mb-3">
                <select name="level_id" class="form-control @error('level_id') is-invalid @enderror" required>
                <option value="">-- Pilih Level --</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                    {{ $level->level_nama }}
                    </option>
                @endforeach
                </select>
            </div>
    
            <div class="input-group mb-3">
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            </div>
    
            <div class="input-group mb-3">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user-circle"></span></div>
            </div>
            </div>
    
            <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            </div>
    
            
    
            <div class="row">
            <div class="col-6">
                <a href="{{ url('login') }}" class="btn btn-link px-0">Sudah punya akun?</a>
            </div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
            </div>
        </form>
    
        </div>
    </div>
    </div>
    
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    </body>
    </html>