@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Selamat Datang Kembali! 👋</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Berikut adalah ringkasan aktivitas bisnis Anda hari ini.</p>
        </div>
        <a href="{{ route('billing.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-sky-600 text-white text-sm font-bold rounded-lg shadow-sm hover:bg-sky-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
            <span>💎 Tambah Kredit</span>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Kredit -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition p-5">
            <div class="flex items-center justify-between">
                <div class="bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-green-500 text-xs font-semibold bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">Active</span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ auth()->user()->credits ?? 0 }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Total Kredit</p>
            </div>
        </div>

        <!-- Card 2: Konten AI -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition p-5">
            <div class="flex items-center justify-between">
                <div class="bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $aiUsage ?? '0' }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Konten Dibuat</p>
            </div>
        </div>

        <!-- Card 3: Scheduled -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition p-5">
             <div class="flex items-center justify-between">
                <div class="bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $scheduled ?? '0' }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Jadwal Pending</p>
            </div>
        </div>

        <!-- Card 4: Gratis Harian -->
        <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl border border-transparent shadow-sm hover:shadow-lg transition p-5 text-white">
            <div class="flex items-center justify-between">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold bg-white/20 px-2 py-1 rounded">Daily</span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-bold">+3</h3>
                <p class="text-sm opacity-80 mt-1">Kredit Gratis</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('ai.caption.index') }}" class="group flex flex-col items-center justify-center p-4 border border-dashed border-slate-200 dark:border-slate-600 rounded-xl hover:border-sky-400 dark:hover:border-sky-500 hover:bg-sky-50 dark:hover:bg-sky-900/20 transition">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📝</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Buat Caption</span>
                <span class="text-xs text-slate-400 dark:text-slate-500 mt-1">1 Kredit</span>
            </a>
             <a href="{{ route('ai.image.index') }}" class="group flex flex-col items-center justify-center p-4 border border-dashed border-slate-200 dark:border-slate-600 rounded-xl hover:border-purple-400 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🖼️</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Generate Gambar</span>
                <span class="text-xs text-slate-400 dark:text-slate-500 mt-1">5 Kredit</span>
            </a>
             <a href="{{ route('social.scheduler.create') }}" class="group flex flex-col items-center justify-center p-4 border border-dashed border-slate-200 dark:border-slate-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📅</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Jadwalkan Post</span>
                <span class="text-xs text-slate-400 dark:text-slate-500 mt-1">Gratis</span>
            </a>
             <a href="{{ route('marketplace.index') }}" class="group flex flex-col items-center justify-center p-4 border border-dashed border-slate-200 dark:border-slate-600 rounded-xl hover:border-yellow-400 dark:hover:border-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition">
                <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🛍️</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Marketplace</span>
                <span class="text-xs text-slate-400 dark:text-slate-500 mt-1">Beli Template</span>
            </a>
        </div>
    </div>

</div>
@endsection
