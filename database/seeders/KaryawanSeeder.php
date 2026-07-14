<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use App\Support\RoleSync;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'nik' => 'DEMO-003',
                'nama' => 'Taylor Smith',
                'username' => 'employee',
                'password' => Hash::make('password'),
                'alamat' => 'Demo Address 3',
                'telepon' => '000-000-0003',
                'posisi' => 'Field Staff',
                'tanggal_lahir' => '1996-08-12',
                'tanggal_masuk' => '2024-03-11',
                'gaji' => 250000,
                'tipe_gaji' => 'harian',
                'status' => 'aktif',
                'role' => Roles::KARYAWAN,
            ]
        );

        RoleSync::sync($user, Roles::KARYAWAN);
    }
}
