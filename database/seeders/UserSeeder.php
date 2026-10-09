<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin / Petugas Tata Usaha
        User::updateOrCreate(
            ['email' => 'admin@madok.test'],
            [
                'name' => 'Administrator TU',
                'nis_nip' => '198507152010011002',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Siswa Penguji
        User::updateOrCreate(
            ['email' => 'siswa@madok.test'],
            [
                'name' => 'Budi Santoso',
                'nis_nip' => '10223001',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
            ]
        );
    }
}