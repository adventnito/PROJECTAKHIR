<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mahasiswa');
    }

    public function dashboard()
    {
        $barang = Barang::where('status', '!=', 'perbaikan')
            ->orderBy('nama')
            ->get();

        $cartItems = session('cart_peminjaman', []);

        return view('mahasiswa.dashboard', compact('barang', 'cartItems'));
    }

    public function showBarang($id)
    {
        $barang = Barang::findOrFail($id);

        if (request()->ajax()) {
            return view('mahasiswa.barang-detail', compact('barang'));
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    public function addToCart(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // PERBAIKAN: Tampilkan stok tersedia di error message
        if (!$barang->canBeBorrowed()) {
            return redirect()->back()->with('error',
                'Barang tidak dapat dipinjam. Stok tersedia: ' . $barang->stok_tersedia
            );
        }

        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            // PERBAIKAN: Validasi menggunakan stok_tersedia
            $totalAkanDipinjam = $cart[$id]['quantity'] + 1;
            if ($totalAkanDipinjam > $barang->stok_tersedia) {
                return redirect()->back()->with('error',
                    'Jumlah melebihi stok tersedia. Stok tersedia: ' . $barang->stok_tersedia
                );
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $barang->id,
                "nama" => $barang->nama,
                "kode_barang" => $barang->kode_barang,
                "quantity" => 1,
                "max_stok" => $barang->stok_tersedia,
                "gambar" => $barang->gambar,
                "status_badge" => $barang->status_badge,
                "status_text" => $barang->status_text
            ];
        }

        session()->put('cart_peminjaman', $cart);
        return redirect()->back()->with('success',
            $barang->nama . ' ditambahkan ke keranjang. Stok tersedia: ' . $barang->stok_tersedia
        );
    }

    public function updateCart(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $barang = Barang::findOrFail($id);

        // PERBAIKAN: Validasi menggunakan stok_tersedia
        if ($quantity < 1 || $quantity > $barang->stok_tersedia) {
            return redirect()->back()->with('error',
                'Jumlah tidak valid. Stok tersedia: ' . $barang->stok_tersedia
            );
        }

        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart_peminjaman', $cart);
            return redirect()->back()->with('success', 'Jumlah berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            $barangName = $cart[$id]['nama'];
            unset($cart[$id]);
            session()->put('cart_peminjaman', $cart);
            return redirect()->back()->with('success', $barangName . ' dihapus dari keranjang');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function clearCart()
    {
        session()->forget('cart_peminjaman');
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Keranjang peminjaman dikosongkan');
    }

    public function showPengajuanForm()
    {
        $cartItems = session('cart_peminjaman', []);

        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Keranjang peminjaman kosong');
        }

        // PERBAIKAN: Validasi stok tersedia
        foreach ($cartItems as $barangId => $item) {
            $barang = Barang::find($barangId);
            if (!$barang || !$barang->canBeBorrowed() || $item['quantity'] > $barang->stok_tersedia) {
                return redirect()->route('mahasiswa.dashboard')->with('error',
                    'Stok ' . ($item['nama'] ?? 'barang') . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok_tersedia ?? 0)
                );
            }
        }

        return view('mahasiswa.pengajuan-form', compact('cartItems'));
    }

    public function submitPeminjaman(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'required|string|min:10|max:500'
        ]);

        $cartItems = session('cart_peminjaman', []);

        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Keranjang peminjaman kosong');
        }

        try {
            // PERBAIKAN: Validasi stok tersedia
            foreach ($cartItems as $barangId => $item) {
                $barang = Barang::find($barangId);

                if (!$barang || !$barang->canBeBorrowed() || $item['quantity'] > $barang->stok_tersedia) {
                    return redirect()->back()->with('error',
                        'Stok ' . ($barang->nama ?? 'barang') . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok_tersedia ?? 0)
                    );
                }
            }

            // Create semua peminjaman
            foreach ($cartItems as $barangId => $item) {
                Peminjaman::create([
                    'user_id' => Auth::id(),
                    'barang_id' => $barangId,
                    'jumlah' => $item['quantity'],
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'alasan' => $request->alasan,
                    'status' => 'pending'
                ]);
            }

            // Clear session
            session()->forget('cart_peminjaman');

            return redirect()->route('mahasiswa.riwayat')->with('success',
                'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.'
            );

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.riwayat', compact('peminjaman'));
    }

    public function profile()
    {
        $user = Auth::user();
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
                                    ->whereIn('status', ['pending', 'disetujui'])
                                    ->count();

        return view('mahasiswa.profile', compact('user', 'totalPeminjaman', 'peminjamanAktif'));
    }

    public function searchBarang(Request $request)
    {
        $keyword = $request->input('search');

        $barang = Barang::where('status', '!=', 'perbaikan')
            ->where(function($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('kode_barang', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->orderBy('nama')
            ->get();

        $cartItems = session('cart_peminjaman', []);

        return view('mahasiswa.dashboard', compact('barang', 'cartItems'));
    }
}
