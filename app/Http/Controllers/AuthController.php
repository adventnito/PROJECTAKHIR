<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah email ada di database
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Email tidak ditemukan, arahkan ke register
            return back()
                ->withErrors([
                    'email' => 'Email tidak terdaftar. Silakan daftar terlebih dahulu.',
                ])
                ->withInput()
                ->with('show_register', true);
        }

        // Cek password
        if (!Auth::attempt($credentials)) {
            // Password salah, tetap di halaman login
            return back()
                ->withErrors([
                    'password' => 'Password salah. Silakan coba lagi.',
                ])
                ->withInput();
        }

        $request->session()->regenerate();
        
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('mahasiswa.dashboard');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'required|string|unique:users|size:12|regex:/^[0-9]+$/',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'required|min:6|confirmed',
        ], [
            'nim.unique' => 'NIM sudah terdaftar. Gunakan NIM yang berbeda.',
            'nim.size' => 'NIM harus terdiri dari 12 digit.',
            'nim.regex' => 'NIM hanya boleh mengandung angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.min' => 'Nomor HP minimal 10 digit.',
            'phone.max' => 'Nomor HP maksimal 15 digit.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di sistem peminjaman inventaris.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}