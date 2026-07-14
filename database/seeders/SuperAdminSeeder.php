<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use App\Support\RoleSync;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nik' => 'DEMO-001',
                'nama' => 'Alex Morgan',
                'username' => 'administrator',
                'password' => Hash::make('password'),
                'alamat' => 'Demo Address 1',
                'telepon' => '000-000-0001',
                'posisi' => 'System Administrator',
                'tanggal_lahir' => '1990-01-15',
                'tanggal_masuk' => '2024-01-08',
                'gaji' => 8000000,
                'tipe_gaji' => 'bulanan',
                'status' => 'aktif',
                'role' => Roles::SUPER_ADMIN,
            ]
        );

        RoleSync::sync($user, Roles::SUPER_ADMIN);
    }
}
