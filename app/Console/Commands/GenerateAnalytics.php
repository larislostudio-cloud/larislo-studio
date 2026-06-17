<?php

namespace App\Console\Commands;

use App\Models\Analytics;
use App\Models\Business;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate and generate daily analytics data for businesses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting analytics generation...');

        // Ambil semua bisnis aktif (bisa dioptimasi dengan chunk jika data besar)
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $this->info("Processing analytics for: {$business->business_name}");

            // Contoh Logic Agregasi Sederhana
            // Di dunia nyata, ini biasanya menjalankan Job untuk fetch data dari API Meta/TikTok
            // Di sini kita buat data dummy/update data yang ada.

            Analytics::updateOrCreate(
                [
                    'business_id' => $business->id,
                    'date' => today()->toDateString(),
                ],
                [
                    // Ini adalah contoh pengisian data. Anda bisa menggantinya dengan rumus nyata
                    'engagement' => rand(100, 5000),
                    'views' => rand(500, 10000),
                    'followers_growth' => rand(-10, 100),
                ]
            );
        }

        $this->info('Analytics generation completed successfully.');
    }
}
