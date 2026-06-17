<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use App\Models\AIContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Demo (Sistem Kredit Baru)
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@larislo.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'pro',
                'credits' => 100,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Demo User created.');

        // 2. Buat Business untuk User Demo
        $business = Business::firstOrCreate(
            ['user_id' => $demoUser->id],
            [
                'business_name' => 'Kopi Susu Larislo',
                'niche' => 'Food & Beverage',
                'logo' => null,
                'description' => 'Coffee shop modern yang menyediakan kopi specialty.'
            ]
        );

        $this->command->info('Demo Business created.');

        // 3. Buat beberapa konten AI History (Sesuai skema baru)
        AIContent::create([
            'user_id' => $demoUser->id,
            'type' => 'caption',
            'status' => 'completed', // Tambahkan status
            'prompt' => 'Promo kopi susu diskon 20%',
            'project_data' => 'Ngopi hemat tapi tetap nikmat ☕🔥 Hari ini diskon 20% untuk semua menu kopi susu! Buruan gas ke Kopi Susu Larislo sebelum kehabisan. #KopiSusu #PromoHemat' // Ganti content jadi project_data
        ]);

        AIContent::create([
            'user_id' => $demoUser->id,
            'type' => 'caption',
            'status' => 'completed', // Tambahkan status
            'prompt' => 'Tips memilih biji kopi',
            'project_data' => 'Mau ngopi tapi bingung pilih biji? 🤔 Robusta buat lo yang suka rasa kuat dan caffeine high. Arabica buat lo yang more smooth dan aromatic. Mau yang mana nih? 🫵' // Ganti content jadi project_data
        ]);

        // 4. Buat Scheduled Post
        \App\Models\ScheduledPost::create([
            'user_id' => $demoUser->id,
            'platform' => 'instagram',
            'content' => 'Selamat pagi! Jangan lupa sarapan kopi dulu yuk biar mood harian mantap.',
            'publish_at' => now()->addDay(),
            'status' => 'scheduled'
        ]);

        $this->command->info('Demo Content & Posts created.');
    }
}
