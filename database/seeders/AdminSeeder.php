<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use App\Support\RoleSync;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'hr@example.com'],
            [
                'nik' => 'DEMO-002',
                'nama' => 'Jamie Lee',
                'username' => 'hr.manager',
                'password' => Hash::make('password'),
                'alamat' => 'Demo Address 2',
                'telepon' => '000-000-0002',
                'posisi' => 'HR Manager',
                'tanggal_lahir' => '1992-04-21',
                'tanggal_masuk' => '2024-02-05',
                'gaji' => 6500000,
                'tipe_gaji' => 'bulanan',
                'status' => 'aktif',
                'role' => Roles::ADMIN,
            ]
        );

        RoleSync::sync($user, Roles::ADMIN);
    }
}
