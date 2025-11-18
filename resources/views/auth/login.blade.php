<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <form method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    
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
                                    @csrf
                                    
                                    @if($errors->any() && ($errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email')))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Registrasi gagal!</strong> Periksa data yang Anda masukkan.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                                       id="register_nim" name="nim" value="{{ old('nim') }}" required 
                                                       placeholder="12 digit NIM" maxlength="12">
                                                @error('nim')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="register_email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="register_email" name="email" value="{{ old('email') }}" required 
                                                   placeholder="email@student.unej.ac.id">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_phone" class="form-label">Nomor HP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark text-white">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                           id="register_phone" name="phone" value="{{ old('phone') }}" required 
                                                           placeholder="08xxxxxxxxxx">
                                                </div>
                                                @error('phone')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                           id="register_password" name="password" required 
                                                           placeholder="Minimal 6 karakter">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register_password')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="register_password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="register_password_confirmation" 
                                                   name="password_confirmation" required placeholder="Ulangi password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register_password_confirmation')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <small>Pastikan NIM terdiri dari 12 digit angka dan data yang dimasukkan valid.</small>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark btn-lg text-white">
                                            <i class="fas fa-user-plus me-2"></i> Daftar Akun Mahasiswa
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted">
                    <small>
                        &copy; 2025 Sistem Peminjaman Inventaris Fasilkom UNEJ. 
                        All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Password toggle function
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.parentNode.querySelector('button i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // NIM validation (12 digit)
        document.getElementById('register_nim')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12);
            }
        });
        
        // Phone number validation
        document.getElementById('register_phone')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Auto switch to register tab if email not found or register errors
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('show_register') || $errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email'))
                const registerTab = new bootstrap.Tab(document.getElementById('pills-register-tab'));
                registerTab.show();
            @endif
            
            // Show success message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 4000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif
        });
        
        // Form submission loading state
        document.getElementById('registerForm')?.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftarkan...';
            btn.disabled = true;
        });
    </script>
</body>
</html>