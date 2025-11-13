@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Peminjaman</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Inventaris</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr>
                        <td>{{ $p->user->name }} ({{ $p->user->nim }})</td>
                        <td>{{ $p->barang->nama }}</td>
                        <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status == 'disetujui' ? 'success' : ($p->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($p->status) }}
                            </span>
                            @if($p->isOverdue())
                                <span class="badge bg-danger">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status == 'pending')
                                <form action="{{ route('admin.peminjaman.approve', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" 
                                            onclick="return confirm('Setujui peminjaman?')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.peminjaman.reject', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Tolak peminjaman?')">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection