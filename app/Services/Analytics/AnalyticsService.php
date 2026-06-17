<?php

namespace App\Services\Analytics;

use App\Repositories\AnalyticsRepository;

class AnalyticsService
{
    protected $repo;

    public function __construct(AnalyticsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function generateReport($businessId, $startDate, $endDate)
    {
        $data = $this->repo->getByDateRange($businessId, $startDate, $endDate);

        return [
            'total_views' => $data->sum('views'),
            'avg_engagement' => $data->avg('engagement'),
            'chart_data' => $data->pluck('views', 'date'),
        ];
    }
}
