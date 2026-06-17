<?php

namespace App\Jobs\Analytics;

use App\Models\Analytics;
use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AggregateDailyStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $businessId;

    /**
     * Create a new job instance.
     * Jika $businessId null, proses semua bisnis.
     */
    public function __construct($businessId = null)
    {
        $this->businessId = $businessId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $query = Business::query();

        if ($this->businessId) {
            $query->where('id', $this->businessId);
        }

        $businesses = $query->get();

        foreach ($businesses as $business) {
            try {
                // 1. Ambil data dari API pihak ketiga (Instagram/Facebook) hari ini
                // $insights = SocialService::fetchInsights($business);

                // Mock Data
                $views = rand(100, 1000);
                $engagement = rand(10, 100);

                // 2. Simpan atau Update ke tabel Analytics
                Analytics::updateOrCreate(
                    [
                        'business_id' => $business->id,
                        'date' => today()->toDateString(),
                    ],
                    [
                        'views' => $views,
                        'engagement' => $engagement,
                        'followers_growth' => 0, // Logic perbandingan dengan hari kemarin
                    ]
                );

            } catch (\Exception $e) {
                Log::error("Analytics Job Failed for Business {$business->id}: " . $e->getMessage());
            }
        }
    }
}
