<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@larislo.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'credits' => 9999, // Beri banyak kredit untuk admin
                'email_verified_at' => now(),
            ]
        );

        // TAMBAHKAN INI: Buat Business untuk Admin jika belum ada
        if (!$admin->business) {
            Business::create([
                'user_id' => $admin->id,
                'business_name' => 'Larislo Headquarters',
                'niche' => 'Software & Technology',
                'description' => 'Main Admin Business Account'
            ]);
        }

        $this->command->info('Admin User & Business created/updated successfully.');
    }
}
