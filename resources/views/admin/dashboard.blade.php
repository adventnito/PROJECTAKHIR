{{-- @extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.barang.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-list"></i> Lihat Semua Barang
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TOTAL BARANG</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_barang'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-sm btn-primary mt-2">
                        Kelola Barang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TOTAL MAHASISWA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_mahasiswa'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-success mt-2">
                        Lihat Mahasiswa
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                PEMINJAMAN PENDING</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['peminjaman_pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-warning mt-2">
                        Proses Peminjaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PEMINJAMAN AKTIF</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['peminjaman_aktif'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-info mt-2">
                        Lihat Aktif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.barang.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i><br>
                                Tambah Barang
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.barang.index') }}" class="btn btn-success w-100">
                                <i class="bi bi-list-ul"></i><br>
                                Lihat Barang
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-warning w-100">
                                <i class="bi bi-clipboard-check"></i><br>
                                Kelola Peminjaman
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-info w-100">
                                <i class="bi bi-people"></i><br>
                                Data Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($peminjaman_terbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Barang</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman_terbaru as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->user->name ?? 'N/A' }}</td>
                                        <td>{{ $peminjaman->barang->nama ?? 'N/A' }}</td>
                                        <td>{{ $peminjaman->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                $peminjaman->status == 'disetujui' ? 'success' :
                                                ($peminjaman->status == 'pending' ? 'warning' : 'danger')
                                            }}">
                                                {{ $peminjaman->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada peminjaman.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    .admin-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        margin: 20px 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
</style>

<div class="admin-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-dark">Admin Panel</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-list"></i> Lihat Semua Barang
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TOTAL BARANG</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_barang'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-primary"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-primary btn-sm mt-2 w-100">
                        Kelola Barang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TOTAL MAHASISWA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_mahasiswa'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-success"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-success btn-sm mt-2 w-100">
                        Lihat Mahasiswa
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                PEMINJAMAN PENDING</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['peminjaman_pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-warning"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-warning btn-sm mt-2 w-100">
                        Proses Peminjaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PEMINJAMAN AKTIF</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['peminjaman_aktif'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-info"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-info btn-sm mt-2 w-100">
                        Lihat Aktif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.barang.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                                Tambah Barang
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.barang.index') }}" class="btn btn-success w-100 py-3">
                                <i class="bi bi-list-ul display-6 d-block mb-2"></i>
                                Lihat Barang
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-warning w-100 py-3">
                                <i class="bi bi-clipboard-check display-6 d-block mb-2"></i>
                                Kelola Peminjaman
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-info w-100 py-3">
                                <i class="bi bi-people display-6 d-block mb-2"></i>
                                Data Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($peminjaman_terbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Barang</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman_terbaru as $peminjaman)
                                    <tr>
                                        <td class="fw-bold">{{ $peminjaman->user->name ?? 'N/A' }}</td>
                                        <td>{{ $peminjaman->barang->nama ?? 'N/A' }}</td>
                                        <td>{{ $peminjaman->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                $peminjaman->status == 'disetujui' ? 'success' :
                                                ($peminjaman->status == 'pending' ? 'warning' : 'danger')
                                            }} text-capitalize">
                                                {{ $peminjaman->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada peminjaman.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
