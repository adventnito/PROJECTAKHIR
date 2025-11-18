@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-4 pb-3">
        <div>
            <h1 class="h2 mb-1 text-blue-dark fw-bold">Dashboard Mahasiswa</h1>
            <p class="text-blue-light mb-0">Sistem Peminjaman Inventaris Fasilkom</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-blue-outline">
                <i class="fas fa-history me-2"></i>Riwayat Peminjaman
            </a>
            <a href="{{ route('mahasiswa.profile') }}" class="btn btn-blue-outline">
                <i class="fas fa-user me-2"></i>Profil Saya
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('mahasiswa.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg border-blue"
                           placeholder="Cari barang berdasarkan nama, kode, atau deskripsi..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-blue-primary px-4">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert Session -->
    @if(session('success'))
        <div class="alert alert-success-blue alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger-blue alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Keranjang Peminjaman -->
    @if(count($cartItems) > 0)
    <div class="card border-warning-blue shadow-sm mb-4">
        <div class="card-header bg-warning-blue text-dark py-3">
            <h5 class="mb-0">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Peminjaman
                <span class="badge bg-danger-blue ms-2">{{ count($cartItems) }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($cartItems as $id => $item)
                <div class="col-md-6">
                    <div class="card card-item-blue border-0">
                        <div class="card-body">
                            <h6 class="card-title text-blue-dark">{{ $item['nama'] }}</h6>
                            <p class="card-text text-blue-light mb-2">
                                <strong>Kode:</strong> {{ $item['kode_barang'] }}<br>
                                <strong>Jumlah:</strong> {{ $item['quantity'] }}<br>
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $item['status_badge'] }}-blue">
                                    {{ $item['status_text'] }}
                                </span>
                            </p>
                            <div class="btn-group">
                                <form action="{{ route('mahasiswa.cart.update', $id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                               min="1" max="{{ $item['max_stok'] }}" class="form-control form-control-sm border-blue">
                                        <button type="submit" class="btn btn-blue-outline btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('mahasiswa.cart.remove', $id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-blue btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <form action="{{ route('mahasiswa.cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger-blue">
                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                    </button>
                </form>
                <a href="{{ route('mahasiswa.pengajuan.form') }}" class="btn btn-success-blue">
                    <i class="fas fa-paper-plane me-2"></i>Ajukan Peminjaman
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Daftar Barang Tersedia -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-blue-dark text-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-boxes me-2"></i>Daftar Barang Tersedia
                <span class="badge bg-blue-light text-blue-dark ms-2">{{ $barang->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($barang->count() > 0)
            <div class="row g-4">
                @foreach($barang as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card card-product-blue border-0 h-100">
                        @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-blue-bg d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-box fa-3x text-blue-medium"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-blue-dark mb-3">{{ $item->nama }}</h5>
                            <div class="mb-2">
                                <strong class="text-blue-light">Kode:</strong>
                                <code class="bg-blue-light text-blue-dark px-2 py-1 rounded">{{ $item->kode_barang }}</code>
                            </div>
                            <div class="mb-2">
                                <strong class="text-blue-light">Stok Tersedia:</strong>
                                <span class="badge bg-{{ $item->stok_tersedia > 0 ? 'success' : 'danger' }}-blue">
                                    {{ $item->stok_tersedia }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-blue-light">Status:</strong>
                                <span class="badge bg-{{ $item->status_badge }}-blue">
                                    {{ $item->status_text }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-blue-outline btn-sm" onclick="showBarangDetail({{ $item->id }})">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </button>

                                @if($item->canBeBorrowed())
                                <form action="{{ route('mahasiswa.cart.add', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-blue-primary btn-sm">
                                        <i class="fas fa-cart-plus me-1"></i>Pinjam
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary-blue btn-sm" disabled>
                                    <i class="fas fa-ban me-1"></i>Tidak Tersedia
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-blue-light mb-3"></i>
                <h5 class="text-blue-dark">Tidak ada barang tersedia</h5>
                <p class="text-blue-light">Semua barang sedang dipinjam atau dalam perbaikan</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div class="modal fade" id="barangDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-dark text-white">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="barangDetailContent">
                <!-- Content akan diisi via JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
/* Color Variables */
:root {
    --blue-dark: #1e3a8a;
    --blue-medium: #3b82f6;
    --blue-light: #dbeafe;
    --blue-bg: #f0f9ff;
    --accent: #f59e0b;
}

/* Text Colors */
.text-blue-dark { color: var(--blue-dark) !important; }
.text-blue-medium { color: var(--blue-medium) !important; }
.text-blue-light { color: #6b7280 !important; }

/* Background Colors */
.bg-blue-dark { background: linear-gradient(135deg, var(--blue-dark), #2563eb) !important; }
.bg-blue-light { background: var(--blue-light) !important; }
.bg-blue-bg { background: var(--blue-bg) !important; }

/* Button Styles */
.btn-blue-primary {
    background: var(--blue-medium);
    border: 2px solid var(--blue-medium);
    color: white;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-blue-primary:hover {
    background: var(--blue-dark);
    border-color: var(--blue-dark);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-blue-outline {
    background: transparent;
    border: 2px solid var(--blue-medium);
    color: var(--blue-medium);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-blue-outline:hover {
    background: var(--blue-medium);
    color: white;
    transform: translateY(-2px);
}

/* Form Controls */
.form-control-lg.border-blue {
    border: 2px solid var(--blue-light);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control-lg.border-blue:focus {
    border-color: var(--blue-medium);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-control-sm.border-blue {
    border: 1px solid var(--blue-light);
    border-radius: 6px;
}

/* Alert Styles */
.alert-success-blue {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 8px;
}

.alert-danger-blue {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 8px;
}

/* Card Styles */
.card-item-blue {
    background: white;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.card-item-blue:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card-product-blue {
    background: white;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card-product-blue:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Badge Colors */
.bg-success-blue {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white;
}

.bg-warning-blue {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    color: white;
}

.bg-danger-blue {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    color: white;
}

.bg-info-blue {
    background: linear-gradient(135deg, var(--blue-medium), var(--blue-dark)) !important;
    color: white;
}

/* Button Variants */
.btn-danger-blue {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    border-radius: 6px;
}

.btn-danger-blue:hover {
    background: #dc2626;
    color: white;
}

.btn-success-blue {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success-blue:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
}

.btn-outline-danger-blue {
    background: transparent;
    border: 2px solid #ef4444;
    color: #ef4444;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-danger-blue:hover {
    background: #ef4444;
    color: white;
}

.btn-secondary-blue {
    background: #9ca3af;
    border: none;
    color: white;
    border-radius: 6px;
}

/* Border Colors */
.border-warning-blue {
    border-color: #f59e0b !important;
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }

    .btn-group {
        width: 100%;
        justify-content: flex-start;
    }

    .btn-group .btn {
        flex: 1;
    }
}
</style>

<script>
function showBarangDetail(barangId) {
    $('#barangDetailContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Memuat detail barang...</p>
        </div>
    `);

    var modal = new bootstrap.Modal(document.getElementById('barangDetailModal'));
    modal.show();

    fetch(`/mahasiswa/barang/${barangId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('barangDetailContent').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('barangDetailContent').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Gagal memuat detail barang.
            </div>
        `;
    });
}

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endsection
