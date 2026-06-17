<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use App\Models\AiContent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ==========================================
        // TAMBAHKAN INI: Cek dan berikan kredit harian
        // ==========================================
        $user->grantDailyFreeCredits();

        // Statistik sederhana
        $totalPosts = ScheduledPost::where('user_id', $user->id)->count();
        $aiUsage = AiContent::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count();

        // Post terjadwal hari ini
        $todayPosts = ScheduledPost::where('user_id', $user->id)
                        ->whereDate('publish_at', today())
                        ->get();

        return view('dashboard.index', compact('totalPosts', 'aiUsage', 'todayPosts'));
    }
}
