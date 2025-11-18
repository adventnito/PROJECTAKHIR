<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 'barang_id', 'jumlah', 'tanggal_pinjam', 
        'tanggal_kembali', 'tanggal_pengembalian', 'status', 
        'alasan', 'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Check if borrowing is overdue
     */
    public function isOverdue()
    {
        return $this->status === 'disetujui' && 
               now()->greaterThan($this->tanggal_kembali) && 
               !$this->tanggal_pengembalian;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'dikembalikan' => 'info'
        ];

        return $statuses[$this->status] ?? 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dikembalikan' => 'Dikembalikan'
        ];

        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }
}