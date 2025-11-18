<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_barang' => Barang::count(),
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'disetujui')->count(),
        ];

        $peminjaman_terbaru = Peminjaman::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'peminjaman_terbaru'));
    }

    // ==================== CRUD BARANG ====================

    public function barangIndex()
    {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    public function barangCreate()
    {
        return view('admin.barang.create');
    }

    public function barangStore(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang-images', 'public');
        }

        Barang::create($validated);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function barangEdit(Barang $barang)
    {
        return view('admin.barang.edit', compact('barang'));
    }

    public function barangUpdate(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('barang-images', 'public');
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function barangDestroy(Barang $barang)
    {
        $peminjaman_aktif = Peminjaman::where('barang_id', $barang->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();
            
        if ($peminjaman_aktif) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus barang yang sedang dipinjam!');
        }

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    // ==================== MANAJEMEN MAHASISWA ====================

    public function mahasiswaIndex()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaPeminjaman(User $user)
    {
        $peminjaman = $user->peminjamans()
            ->with('barang')
            ->latest()
            ->get();

        return view('admin.mahasiswa.peminjaman', compact('user', 'peminjaman'));
    }

    // ==================== MANAJEMEN PEMINJAMAN ====================

    public function peminjamanIndex()
    {
        $peminjaman = Peminjaman::with(['user', 'barang'])
            ->latest()
            ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approvePeminjaman(Peminjaman $peminjaman)
    {
        $barang = $peminjaman->barang;
        
        // PERBAIKAN: Validasi menggunakan stok_tersedia sebelum approve
        if ($peminjaman->jumlah > $barang->stok_tersedia) {
            return back()->with('error', 
                'Stok barang tidak mencukupi! Stok tersedia: ' . $barang->stok_tersedia
            );
        }

        // PERBAIKAN: Simpan stok sebelum perubahan
        $stokSebelum = $barang->stok;
        
        // Update status peminjaman menjadi DISETUJUI
        $peminjaman->update([
            'status' => 'disetujui',
            'catatan_admin' => request('catatan_admin', 'Peminjaman disetujui')
        ]);

        // PERBAIKAN: Tidak perlu kurangi stok fisik di sini
        // Stok fisik tetap, yang berubah adalah status peminjaman
        // Perhitungan stok_tersedia akan otomatis menyesuaikan

        // Update status barang jika stok tersedia = 0
        if ($barang->stok_tersedia <= 0) {
            $barang->update(['status' => 'dipinjam']);
        }

        return back()->with('success', 
            'Peminjaman disetujui! Stok tersedia ' . $barang->nama . ': ' . $barang->stok_tersedia
        );
    }

    public function rejectPeminjaman(Peminjaman $peminjaman)
    {
        // Update status peminjaman menjadi DITOLAK
        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => request('catatan_admin', 'Peminjaman ditolak')
        ]);

        // PERBAIKAN: Jika sebelumnya status disetujui, stok_tersedia akan otomatis bertambah
        // karena status berubah dari disetujui ke ditolak

        return back()->with('success', 'Peminjaman ditolak!');
    }

    public function completePeminjaman(Peminjaman $peminjaman)
    {
        $barang = $peminjaman->barang;
        
        // Update status peminjaman menjadi DIKEMBALIKAN
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_pengembalian' => now(),
            'catatan_admin' => request('catatan_admin', 'Barang telah dikembalikan')
        ]);

        // PERBAIKAN: Update status barang jika stok tersedia > 0
        if ($barang->stok_tersedia > 0 && $barang->status === 'dipinjam') {
            $barang->update(['status' => 'tersedia']);
        }

        return back()->with('success', 
            'Barang berhasil dikembalikan! Stok tersedia ' . $barang->nama . ': ' . $barang->stok_tersedia
        );
    }
}