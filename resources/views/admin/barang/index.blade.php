@extends('layouts.admin')

@section('title', 'Management Barang')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="bi bi-box-seam"></i> Management Barang
        </h1>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Barang Baru
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabel Barang -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Barang</h5>
        </div>
        <div class="card-body">
            @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $barang->kode_barang }}</span>
                                </td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->deskripsi ? Str::limit($barang->deskripsi, 50) : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $barang->stok > 0 ? 'success' : 'danger' }}">
                                        {{ $barang->stok }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $barang->status == 'tersedia' ? 'success' : 
                                        ($barang->status == 'dipinjam' ? 'warning' : 'secondary') 
                                    }}">
                                        {{ $barang->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}" 
                                             alt="{{ $barang->nama }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.barang.edit', $barang->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.barang.destroy', $barang->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin hapus barang {{ $barang->nama }}?')"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="text-muted">Belum ada barang</h4>
                    <p class="text-muted">Silakan tambah barang terlebih dahulu</p>
                    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Barang Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection