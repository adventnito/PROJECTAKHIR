<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Peminjaman Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px 15px 0 0;
            color: white;
            padding: 2rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-register {
            background: #28a745;
            border: none;
        }
        .nav-pills .nav-link {
            color: #495057;
            font-weight: 500;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card login-card">
                    <div class="login-header text-center">
                        <h2><i class="fas fa-boxes"></i></h2>
                        <h3 class="mb-0">Sistem Peminjaman Inventaris</h3>
                        <p class="mb-0">Fasilkom</p>
                    </div>
                    
                    <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" 
                                    data-bs-target="#pills-login" type="button" role="tab">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" 
                                    data-bs-target="#pills-register" type="button" role="tab">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4" id="pills-tabContent">
                        <!-- Login Form -->
                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel">
                            <form method="POST" action="{{ url('/login') }}">
                                @csrf
                                
                                @if($errors->any() && !$errors->has('name') && !$errors->has('nim'))
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="login_email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="login_email" name="email" value="{{ old('email') }}" required 
                                               placeholder="Masukkan email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="login_password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="login_password" name="password" required 
                                               placeholder="Masukkan password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-login btn-lg text-white">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Register Form -->
                        <div class="tab-pane fade" id="pills-register" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                @if($errors->any() && ($errors->has('name') || $errors->has('nim') || $errors->has('phone')))
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="register_name" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="register_name" name="name" value="{{ old('name') }}" required 
                                                   placeholder="Nama lengkap">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="register_nim" class="form-label">NIM</label>
                                            <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                                   id="register_nim" name="nim" value="{{ old('nim') }}" required 
                                                   placeholder="Nomor NIM">
                                            @error('nim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="register_email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="register_email" name="email" value="{{ old('email') }}" required 
                                               placeholder="Email aktif">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="register_phone" class="form-label">Nomor HP</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                       id="register_phone" name="phone" value="{{ old('phone') }}" required 
                                                       placeholder="Nomor HP">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="register_password" class="form-label">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="register_password" name="password" required 
                                                   placeholder="Password minimal 6 karakter">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="register_password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="register_password_confirmation" 
                                           name="password_confirmation" required placeholder="Ulangi password">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-register btn-lg text-white">
                                        <i class="fas fa-user-plus"></i> Daftar sebagai Mahasiswa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        // Auto switch to register tab if there are register errors
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email'))
                var registerTab = new bootstrap.Tab(document.getElementById('pills-register-tab'));
                registerTab.show();
            @endif
        });
    </script>
</body>
</html>