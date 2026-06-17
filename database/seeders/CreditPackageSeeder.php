<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class CreditPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan DB::table atau Model langsung
        DB::table('credit_packages')->insert([
            [
                'name' => 'Starter Pack',
                'credits' => 10,
                'price' => 10000,
                'bonus' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Growth Pack',
                'credits' => 50,
                'price' => 45000,
                'bonus' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Business Pack',
                'credits' => 100,
                'price' => 80000,
                'bonus' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Agency Pack',
                'credits' => 500,
                'price' => 350000,
                'bonus' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
