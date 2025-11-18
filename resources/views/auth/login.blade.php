<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- PASTIKAN INI ADA -->
    <title>Login - Sistem Peminjaman Inventaris Fasilkom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark text-white text-center py-4">
                        <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                            <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="img-fluid" style="height: 30px;" onerror="this.style.display='none'">
                            <img src="{{ asset('storage/images/fasilkom.png') }}" alt="Fasilkom" class="img-fluid" style="height: 25px; filter: brightness(0) invert(1);" onerror="this.style.display='none'">
                        </div>
                        <h4 class="mb-2">Sistem Peminjaman Inventaris</h4>
                        <p class="mb-0 opacity-75">Fakultas Ilmu Komputer - Universitas Jember</p>
                    </div>

                    <div class="card-body p-4">
                        <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-login" type="button" role="tab">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-register" type="button" role="tab">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="pills-login" role="tabpanel">
                                <form method="POST" action="{{ route('login.post') }}"> <!-- GUNAKAN ROUTE NAME -->
                                    @csrf <!-- PASTIKAN INI ADA -->

                                    @if($errors->any() && $errors->has('email') && !$errors->has('name'))
                                        <div class="alert alert-warning alert-dismissible fade show">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $errors->first('email') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if($errors->any() && $errors->has('password'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="fas fa-lock me-2"></i>
                                            {{ $errors->first('password') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="login_email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="login_email" name="email" value="{{ old('email') }}" required
                                                   placeholder="email@example.com">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="login_password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="login_password" name="password" required
                                                   placeholder="Masukkan password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('login_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark btn-lg text-white">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login ke Sistem
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="pills-register" role="tabpanel">
                                <form method="POST" action="{{ route('register') }}" id="registerForm">
                                    @csrf <!-- PASTIKAN INI ADA -->

                                    <!-- rest of register form -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
