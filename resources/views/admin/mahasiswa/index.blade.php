{{-- @extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Mahasiswa</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Total Peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->name }}</td>
                        <td>{{ $mhs->email }}</td>
                        <td>{{ $mhs->phone }}</td>
                        <td>{{ $mhs->peminjamans->count() }}</td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.peminjaman', $mhs->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Peminjaman
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}



@extends('layouts.admin')

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
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2 text-dark">
            <i class="bi bi-people"></i> Data Mahasiswa
        </h1>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="card">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Mahasiswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Total Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswa as $mhs)
                        <tr>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $mhs->nim }}</span>
                            </td>
                            <td class="fw-bold">{{ $mhs->name }}</td>
                            <td>{{ $mhs->email }}</td>
                            <td>{{ $mhs->phone }}</td>
                            <td>
                                <span class="badge bg-info fs-6">
                                    {{ $mhs->peminjamans->count() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.mahasiswa.peminjaman', $mhs->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Peminjaman
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
