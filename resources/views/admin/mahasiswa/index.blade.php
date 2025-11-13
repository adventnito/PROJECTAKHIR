@extends('layouts.admin')

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
@endsection