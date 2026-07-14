<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->call([
                SuperAdminSeeder::class,
                AdminSeeder::class,
                KaryawanSeeder::class,
                DemoOperationalDataSeeder::class,
            ]);
        }
    }
}
