@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard Mahasiswa</h2>
                <div class="btn-group">
                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history"></i> Riwayat Peminjaman
                    </a>
                    <a href="{{ route('mahasiswa.profile') }}" class="btn btn-outline-info">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('mahasiswa.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari barang berdasarkan nama, kode, atau deskripsi..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alert Session -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Keranjang Peminjaman -->
            @if(count($cartItems) > 0)
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart"></i> Keranjang Peminjaman
                        <span class="badge bg-danger">{{ count($cartItems) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($cartItems as $id => $item)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $item['nama'] }}</h6>
                                    <p class="card-text">
                                        <strong>Kode:</strong> {{ $item['kode_barang'] }}<br>
                                        <strong>Jumlah:</strong> {{ $item['quantity'] }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ $item['status_badge'] }}">
                                            {{ $item['status_text'] }}
                                        </span>
                                    </p>
                                    <div class="btn-group">
                                        <form action="{{ route('mahasiswa.cart.update', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                       min="1" max="{{ $item['max_stok'] }}" class="form-control" style="width: 80px;">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <form action="{{ route('mahasiswa.cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <form action="{{ route('mahasiswa.cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Kosongkan Keranjang
                            </button>
                        </form>
                        <a href="{{ route('mahasiswa.pengajuan.form') }}" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Daftar Barang Tersedia -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes"></i> Daftar Barang Tersedia
                        <span class="badge bg-light text-dark">{{ $barang->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($barang->count() > 0)
                    <div class="row">
                        @foreach($barang as $item)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                                @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nama }}</h5>
                                    <p class="card-text">
                                        <strong>Kode:</strong> <code>{{ $item->kode_barang }}</code><br>
                                        <strong>Stok Tersedia:</strong> 
                                        <span class="badge bg-{{ $item->stok_tersedia > 0 ? 'success' : 'danger' }}">
                                            {{ $item->stok_tersedia }}
                                        </span><br>
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $item->status_badge }}">
                                            {{ $item->status_text }}
                                        </span>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-info btn-sm" onclick="showBarangDetail({{ $item->id }})">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        
                                        @if($item->canBeBorrowed())
                                        <form action="{{ route('mahasiswa.cart.add', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus"></i> Pinjam
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-ban"></i> Tidak Tersedia
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5>Tidak ada barang tersedia</h5>
                        <p class="text-muted">Semua barang sedang dipinjam atau dalam perbaikan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div class="modal fade" id="barangDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="barangDetailContent">
                <!-- Content akan diisi via JavaScript -->
            </div>
        </div>
    </div>
</div>

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