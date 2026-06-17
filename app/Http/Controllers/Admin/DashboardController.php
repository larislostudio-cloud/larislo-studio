<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Users
        $totalUsers = User::count();

        // 2. Kredit Terjual (Hanya yang status paid)
        $totalCreditsSold = Transaction::where('status', 'paid')->sum('amount');

        // 3. Revenue (Hanya yang status paid)
        $revenue = Transaction::where('status', 'paid')->sum('price');

        // 4. Jumlah Transaksi Pending (Untuk notif admin)
        $pendingPayments = Transaction::where('status', 'pending')->count();

        // 5. 5 Transaksi Terbaru (Untuk tabel)
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.index', compact(
            'totalUsers',
            'totalCreditsSold',
            'revenue',
            'pendingPayments',
            'recentTransactions'
        ));
    }
}
