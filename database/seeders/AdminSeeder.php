<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin1@vulkanstore.com'],
            [
                'nama_lengkap' => 'Administrator',
                'role' => 'Admin',
                'password' => Hash::make('password123'),
                'status_aktif' => 'Aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin2@vulkanstore.com'],
            [
                'nama_lengkap' => 'Administrator 2',
                'role' => 'Admin',
                'password' => Hash::make('password123'),
                'status_aktif' => 'Aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin3@vulkanstore.com'],
            [
                'nama_lengkap' => 'Administrator 3',
                'role' => 'Admin',
                'password' => Hash::make('password123'),
                'status_aktif' => 'Tidak Aktif',
            ]
        );
    }
}
