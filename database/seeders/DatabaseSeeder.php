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
            AdminSeeder::class,     // Buat user admin
            CreditPackageSeeder::class,     // Buat paket langganan dulu
            DemoSeeder::class,      // Buat data demo (opsional)
        ]);
    }
}
