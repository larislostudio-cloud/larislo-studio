<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tanggal jika ada
        $from = $request->get('from', now()->startOfMonth());
        $to = $request->get('to', now()->endOfMonth());

        $stats = Analytics::with('business')
                    ->whereBetween('date', [$from, $to])
                    ->orderBy('date', 'desc')
                    ->paginate(15);

        return view('admin.analytics.index', compact('stats'));
    }
}
