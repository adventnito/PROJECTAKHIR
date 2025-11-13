<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Admin Fasilkom',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890'
        ]);

        // Sample Mahasiswa
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role' => 'mahasiswa',
            'nim' => '123456789',
            'phone' => '081234567891'
        ]);

        // Sample Barang - UBAH JADI 'nama'
        Barang::create([
            'kode_barang' => 'P-001',
            'nama' => 'Palu Presidium', // 'nama' SAJA
            'deskripsi' => 'Palu untuk persidangan',
            'stok' => 5,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'PRO-001',
            'nama' => 'Projector Epson', // 'nama' SAJA
            'deskripsi' => 'Projector untuk presentasi',
            'stok' => 3,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'RUANG-B1',
            'nama' => 'Ruang Kelas B1', // CONTOH BUKAN BARANG
            'deskripsi' => 'Ruang kelas B1 Fasilkom',
            'stok' => 1,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'RUANG-LP',
            'nama' => 'Lab Pertanian Cerdas', // CONTOH BUKAN BARANG
            'deskripsi' => 'Laboratorium IoT untuk praktikum',
            'stok' => 1,
            'status' => 'tersedia'
        ]);
    }
}