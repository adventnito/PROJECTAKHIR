<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman - Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #333;
            padding: 12px 15px;
            margin: 2px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #28a745;
            color: white;
        }
        .stat-card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .barang-item {
            border-left: 4px solid #28a745;
            transition: all 0.3s;
        }
        .barang-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <h5 class="px-3 text-success">Mahasiswa Panel</h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('mahasiswa.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.barang.index') }}">
                                <i class="bi bi-box-seam"></i> Daftar Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.peminjaman.index') }}">
                                <i class="bi bi-clipboard-check"></i> Status Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mahasiswa.barang.terakhir-dilihat') }}">
                                <i class="bi bi-clock-history"></i> Terakhir Dilihat
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100 text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 text-success">Sistem Peminjaman - Mahasiswa</h1>
                    <span class="badge bg-success">Mahasiswa</span>
                </div>

                <!-- Welcome Section -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Selamat Datang, {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informasi Mahasiswa</h5>
                                <p><strong>NIM:</strong> {{ $user->nim ?? 'Belum diisi' }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Telepon:</strong> {{ $user->phone ?? 'Belum diisi' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Statistik Peminjaman</h5>
                                <p><strong>Total Peminjaman:</strong> {{ $total_peminjaman }}</p>
                                <p><strong>Barang Tersedia:</strong> {{ $barang_tersedia }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Peminjaman Terbaru -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h5>
                            </div>
                            <div class="card-body">
                                @if($peminjaman_terbaru->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($peminjaman_terbaru as $peminjaman)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $peminjaman->barang->nama ?? 'N/A' }}</h6>
                                                <small class="text-muted">{{ $peminjaman->created_at->format('d/m/Y') }}</small>
                                            </div>
                                            <span class="badge bg-{{
                                                $peminjaman->status == 'disetujui' ? 'success' :
                                                ($peminjaman->status == 'pending' ? 'warning' : 'danger')
                                            }}">
                                                {{ $peminjaman->status }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Belum ada riwayat peminjaman.</p>
                                    <a href="{{ route('mahasiswa.barang.index') }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-box-arrow-in-right"></i> Pinjam Barang Pertama
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Barang Popular -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-star"></i> Barang Popular</h5>
                            </div>
                            <div class="card-body">
                                @if($barang_popular->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($barang_popular as $barang)
                                        <div class="list-group-item barang-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $barang->nama }}</h6>
                                                    <small class="text-muted">Kode: {{ $barang->kode_barang }} | Stok: {{ $barang->stok }}</small>
                                                </div>
                                                <a href="{{ route('mahasiswa.barang.index') }}?focus={{ $barang->id }}"
                                                   class="btn btn-outline-success btn-sm">
                                                    Pinjam
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada barang popular.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terakhir Dilihat -->
                @if($terakhir_dilihat->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Barang Terakhir Dilihat</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($terakhir_dilihat as $barang)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $barang->nama }}</h6>
                                                <p class="card-text text-muted">
                                                    <small>Kode: {{ $barang->kode_barang }}</small><br>
                                                    <small>Stok: {{ $barang->stok }}</small>
                                                </p>
                                                <a href="{{ route('mahasiswa.barang.index') }}?focus={{ $barang->id }}"
                                                   class="btn btn-success btn-sm w-100">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('mahasiswa.barang.index') }}" class="btn btn-success w-100">
                                    <i class="bi bi-box-seam"></i><br>
                                    Lihat Semua Barang
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('mahasiswa.peminjaman.index') }}" class="btn btn-info w-100">
                                    <i class="bi bi-clipboard-check"></i><br>
                                    Status Peminjaman
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('mahasiswa.barang.terakhir-dilihat') }}" class="btn btn-warning w-100">
                                    <i class="bi bi-clock-history"></i><br>
                                    Terakhir Dilihat
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-box-arrow-right"></i><br>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif

    <script>
        // Fungsi helper cookie
        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Simpan barang yang dilihat ke cookie
        function simpanKeRiwayat(barangId) {
            let riwayat = JSON.parse(getCookie('barang_terakhir_dilihat') || '[]');

            // Hapus jika sudah ada
            riwayat = riwayat.filter(id => id != barangId);

            // Tambahkan ke depan
            riwayat.unshift(barangId);

            // Batasi maksimal 10 item
            riwayat = riwayat.slice(0, 10);

            // Simpan ke cookie (30 hari)
            setCookie('barang_terakhir_dilihat', JSON.stringify(riwayat), 30);
        }

        // Simpan ke riwayat ketika halaman dimuat
        @if(request()->has('focus'))
            simpanKeRiwayat({{ request()->focus }});
        @endif
    </script>
</body>
</html>
