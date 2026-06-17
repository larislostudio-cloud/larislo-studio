@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">System Overview</h1>

    <!-- ===================== STATS CARDS ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <!-- Card 1: Total Users -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Card 2: Kredit Terjual -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Kredit Terjual</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $totalCreditsSold }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>

        <!-- Card 3: Pending Payment (NEW) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Pending Payment</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $pendingPayments }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <!-- Card 4: Revenue -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Revenue (IDR)</p>
                    <p class="text-2xl font-bold text-sky-600 mt-1">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center text-sky-600">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== RECENT TRANSACTIONS (NEW) ===================== -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Transaksi Terbaru</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-sky-600 hover:underline">Lihat Semua</a>
        </div>

        @if($recentTransactions->count() > 0)
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Paket</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentTransactions as $trx)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $trx->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">{{ $trx->credit_package_name ?? $trx->amount . ' Credits' }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($trx->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        @if($trx->status == 'pending')
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700 font-medium">Pending</span>
                        @elseif($trx->status == 'paid')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700 font-medium">Paid</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 font-medium">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($trx->status == 'pending')
                        <form action="{{ route('admin.transactions.validate', $trx->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs bg-sky-600 text-white px-3 py-1 rounded hover:bg-sky-700">Validasi</button>
                        </form>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 text-center py-4">Belum ada transaksi.</p>
        @endif
    </div>

    <!-- ===================== OTHER STATS ===================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Penggunaan Kredit -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Penggunaan Kredit Mingguan</h3>
            <div class="h-48 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 border border-dashed">
                [ Grafik Line Chart Credit Usage ]
            </div>
        </div>

        <!-- Top User -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Top User (Highest Credits)</h3>
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">User</th>
                        <th class="py-2">Credits</th>
                        <th class="py-2">Last Active</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Simple query for top users (could be moved to controller)
                    $topUsers = \App\Models\User::orderByDesc('credits')->take(5)->get();
                    @endphp
                    @foreach($topUsers as $u)
                    <tr class="border-b">
                        <td class="py-2">{{ $u->name }}</td>
                        <td class="py-2 font-bold text-sky-600">{{ $u->credits }}</td>
                        <td class="py-2 text-gray-500">{{ $u->updated_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
