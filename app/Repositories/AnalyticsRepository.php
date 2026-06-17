<?php

namespace App\Repositories;

use App\Models\Analytics;
use Illuminate\Support\Facades\DB;

class AnalyticsRepository
{
    protected $model;

    public function __construct(Analytics $model)
    {
        $this->model = $model;
    }

    /**
     * Ambil data analytics untuk bisnis tertentu dalam rentang tanggal.
     */
    public function getByDateRange($businessId, $startDate, $endDate)
    {
        return $this->model->where('business_id', $businessId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Simpan atau update data analytics harian.
     */
    public function storeDailyStats(array $data)
    {
        return $this->model->updateOrCreate(
            [
                'business_id' => $data['business_id'],
                'date' => $data['date'],
            ],
            [
                'engagement' => $data['engagement'] ?? 0,
                'views' => $data['views'] ?? 0,
                'followers_growth' => $data['followers_growth'] ?? 0,
            ]
        );
    }

    /**
     * Hitung total engagement untuk bisnis.
     */
    public function getTotalEngagement($businessId)
    {
        return $this->model->where('business_id', $businessId)->sum('engagement');
    }

    /**
     * Ambil data untuk grafik (misal 7 hari terakhir).
     */
    public function getChartData($businessId, $days = 7)
    {
        return $this->model->where('business_id', $businessId)
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->select('date', 'views', 'engagement')
            ->get();
    }
}
