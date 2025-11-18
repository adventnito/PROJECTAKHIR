<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang', 'nama', 'deskripsi', 'stok', 'status', 'gambar'
    ];

    protected $table = 'barangs';

    protected $appends = ['stok_tersedia', 'is_available', 'status_badge', 'status_text'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * PERBAIKAN: Hitung stok tersedia yang benar
     * Stok Tersedia = Stok Fisik - Total yang sedang dipinjam (disetujui)
     */
    public function getStokTersediaAttribute()
    {
        // Jika status perbaikan, stok tersedia = 0
        if ($this->status === 'perbaikan') {
            return 0;
        }

        try {
            // Hitung total yang sedang dipinjam (status disetujui)
            $totalDipinjam = $this->peminjamans()
                ->where('status', 'disetujui')
                ->sum('jumlah');

            $stokTersedia = $this->stok - $totalDipinjam;

            // Pastikan tidak minus dan maksimal stok fisik
            return max(0, min($stokTersedia, $this->stok));

        } catch (\Exception $e) {
            // Fallback ke stok fisik jika error
            return $this->stok;
        }
    }

    /**
     * PERBAIKAN: Cek apakah bisa dipinjam
     */
    public function getIsAvailableAttribute()
    {
        return $this->stok_tersedia > 0 && $this->status === 'tersedia';
    }

    /**
     * PERBAIKAN: Method untuk peminjaman
     */
    public function canBeBorrowed()
    {
        return $this->is_available;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'tersedia' => 'success',
            'dipinjam' => 'warning',
            'perbaikan' => 'danger'
        ];

        return $statuses[$this->status] ?? 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'tersedia' => 'Tersedia',
            'dipinjam' => 'Sedang Dipinjam',
            'perbaikan' => 'Dalam Perbaikan'
        ];

        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }

    /**
     * Scope for available items
     */
    public function scopeTersedia($query)
    {
        return $query->where('status', '!=', 'perbaikan');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('kode_barang', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
    }

    /**
     * Get image URL or placeholder
     */
    public function getImageUrlAttribute()
    {
        if ($this->gambar && file_exists(storage_path('app/public/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/placeholder-item.png');
    }

    /**
     * Get short description
     */
    public function getDeskripsiSingkatAttribute()
    {
        return $this->deskripsi ? Str::limit($this->deskripsi, 100) : 'Tidak ada deskripsi';
    }
}
