<div class="row">
    <div class="col-md-6">
        @if($barang->gambar)
            <img src="{{ asset('storage/' . $barang->gambar) }}" 
                 alt="{{ $barang->nama }}" 
                 class="img-fluid rounded"
                 style="max-height: 300px; object-fit: cover;">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                 style="height: 200px;">
                <i class="fas fa-box fa-3x text-muted"></i>
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <h4 class="text-primary">{{ $barang->nama }}</h4>
        <table class="table table-borderless">
            <tr>
                <td width="40%"><strong>Kode Barang</strong></td>
                <td><code class="fs-6">{{ $barang->kode_barang }}</code></td>
            </tr>
            <tr>
                <td><strong>Stok Total</strong></td>
                <td><span class="badge bg-secondary fs-6">{{ $barang->stok }}</span></td>
            </tr>
            <tr>
                <td><strong>Stok Tersedia</strong></td>
                <td><span class="badge bg-success fs-6">{{ $barang->stok_tersedia }}</span></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>
                    <span class="badge bg-{{ $barang->status_badge }} fs-6">
                        {{ $barang->status_text }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Deskripsi</strong></td>
                <td>{{ $barang->deskripsi ?: '<em class="text-muted">Tidak ada deskripsi</em>' }}</td>
            </tr>
        </table>
        
        <div class="mt-4">
            @if($barang->canBeBorrowed())
                <form action="{{ route('mahasiswa.cart.add', $barang->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="fas fa-ban"></i> 
                    {{ $barang->status === 'perbaikan' ? 'Dalam Perbaikan' : 'Tidak Tersedia' }}
                </button>
            @endif
        </div>
    </div>
</div>