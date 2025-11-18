@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Tombol Back -->
    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
    </a>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                    </h4>
                </div>
                <div class="card-body">
                    @if($peminjaman->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman as $pinjam)
                                    <tr>
                                        <td>{{ $pinjam->barang->nama }}</td>
                                        <td>{{ $pinjam->jumlah }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'disetujui' => 'success',
                                                    'ditolak' => 'danger',
                                                    'dikembalikan' => 'info'
                                                ][$pinjam->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }} text-capitalize">
                                                {{ $pinjam->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($pinjam->status === 'disetujui')
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="fas fa-check"></i> Disetujui
                                                </button>
                                            @elseif($pinjam->status === 'pending')
                                                <button class="btn btn-warning btn-sm" disabled>
                                                    <i class="fas fa-clock"></i> Menunggu
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $peminjaman->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-4x text-muted mb-3"></i>
                            <h5>Belum ada riwayat peminjaman</h5>
                            <p class="text-muted">Mulai pinjam barang untuk melihat riwayat di sini</p>
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-boxes me-2"></i>Pinjam Barang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
