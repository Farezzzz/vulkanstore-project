<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Pemasok;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::create([
            'Nama_Lengkap' => 'Andi Ardiansyah',
            'Role' => 'Admin',
            'Kata_Sandi' => Hash::make('password123'),
            'Email' => 'andi@vulkanstore.com',
            'Status_Aktif' => 'Aktif',
        ]);

        Pengguna::create([
            'Nama_Lengkap' => 'Siti Permata',
            'Role' => 'Admin',
            'Kata_Sandi' => Hash::make('password123'),
            'Email' => 'siti@vulkanstore.com',
            'Status_Aktif' => 'Aktif',
        ]);

        Pengguna::create([
            'Nama_Lengkap' => 'Budi Pratama',
            'Role' => 'Admin',
            'Kata_Sandi' => Hash::make('password123'),
            'Email' => 'budi@vulkanstore.com',
            'Status_Aktif' => 'Aktif',
        ]);

        Pemasok::create([
            'Nama_Pemasok' => 'PT. Logistik Jaya',
            'Kontak_Pemasok' => '0812-3456-7890',
            'Kategori_Pemasok' => 'INTERNAL',
        ]);

        Pemasok::create([
            'Nama_Pemasok' => 'CV. Berkah Abadi',
            'Kontak_Pemasok' => '0856-9876-5432',
            'Kategori_Pemasok' => 'EXTERNAL (DIVISI VULKANISIR)',
        ]);

        Barang::create([
            'Nama_Barang' => 'Industrial Piston V2',
            'Kategori_Barang' => 'Ban',
            'Stok_Tersedia' => 1200,
            'Harga_Jual' => 500000,
        ]);

        Barang::create([
            'Nama_Barang' => 'Heavy Duty Copper Wire 50m',
            'Kategori_Barang' => 'Aki',
            'Stok_Tersedia' => 15,
            'Harga_Jual' => 1250000,
        ]);
    }
}
