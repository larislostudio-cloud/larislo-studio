@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 transition-colors duration-500">
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <!-- ==================== HEADER ==================== -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-sm shadow-lg shadow-violet-500/20">📊</span>
                    Analytics Hub
                </h1>
                <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Pantau performa bisnis, konten, dan konversi Anda secara real-time.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Date Range Picker (Simulated) -->
                <div class="relative flex-1 md:flex-none">
                    <select id="dateRange" onchange="showToast('Filter diperbarui', 'info')" class="w-full md:w-48 appearance-none bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl px-4 py-2.5 pr-8 text-sm text-gray-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
                        <option>Last 7 Days</option>
                        <option selected>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>This Year</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                <button onclick="showToast('Laporan sedang diunduh...', 'success')" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-xl font-medium text-sm transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                </button>
            </div>
        </div>

        <!-- ==================== STATS GRID ==================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Card: Total Views -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-violet-500/10 rounded-full -mr-4 -mt-4 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Views</span>
                        <div class="w-8 h-8 bg-violet-100 dark:bg-violet-900/30 rounded-lg flex items-center justify-center text-violet-600 dark:text-violet-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">124,850</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +12.5% from last month
                    </p>
                </div>
            </div>

            <!-- Card: Engagement -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-pink-500/10 rounded-full -mr-4 -mt-4 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Engagement</span>
                        <div class="w-8 h-8 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center text-pink-600 dark:text-pink-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">6.8%</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +2.3% from last month
                    </p>
                </div>
            </div>

            <!-- Card: Revenue -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/10 rounded-full -mr-4 -mt-4 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Revenue</span>
                        <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp 45.2M</p>
                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        -4.1% from last month
                    </p>
                </div>
            </div>

            <!-- Card: Conversion -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-sky-500/10 rounded-full -mr-4 -mt-4 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Conversion</span>
                        <div class="w-8 h-8 bg-sky-100 dark:bg-sky-900/30 rounded-lg flex items-center justify-center text-sky-600 dark:text-sky-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">3.2%</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +0.8% from last month
                    </p>
                </div>
            </div>
        </div>

        <!-- ==================== MAIN CHART & FUNNEL ==================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Traffic Overview Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 dark:text-white">Traffic Overview</h3>
                    <div class="flex items-center gap-1 bg-gray-100 dark:bg-slate-700 rounded-lg p-0.5">
                        <button class="chart-tab px-3 py-1.5 text-xs font-medium rounded-md bg-white dark:bg-slate-600 text-gray-900 dark:text-white shadow-sm transition" data-type="views">Views</button>
                        <button class="chart-tab px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 transition" data-type="revenue">Revenue</button>
                    </div>
                </div>
                <!-- CSS-only Chart Simulation -->
                <div class="flex items-end justify-between gap-2 h-56 pt-4 border-b border-gray-100 dark:border-slate-700 pb-2">
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">1.2k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 40%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Mon</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">2.8k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 70%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Tue</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">1.5k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 45%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Wed</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">4.1k</span>
                            <div class="w-full bg-violet-500 dark:bg-violet-400 rounded-t-md transition-all group-hover:bg-violet-600" style="height: 95%"></div>
                        </div>
                        <span class="text-[10px] text-violet-500 font-bold mt-1">Thu</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">3.5k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 80%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Fri</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">2.1k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 55%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Sat</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer">
                        <div class="w-full relative">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-gray-500 dark:text-slate-400 opacity-0 group-hover:opacity-100 transition">1.9k</span>
                            <div class="w-full bg-violet-200 dark:bg-violet-900/40 rounded-t-md transition-all group-hover:bg-violet-500 dark:group-hover:bg-violet-400" style="height: 50%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Sun</span>
                    </div>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6">Conversion Funnel</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Page Views</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">124,850</span>
                        </div>
                        <div class="w-full h-8 bg-violet-100 dark:bg-violet-900/30 rounded-lg overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 rounded-lg" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Add to Cart</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">12,450</span>
                        </div>
                        <div class="w-full h-8 bg-pink-100 dark:bg-pink-900/30 rounded-lg overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg" style="width: 45%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Checkout</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">5,200</span>
                        </div>
                        <div class="w-full h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg" style="width: 20%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Purchase</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">3,920</span>
                        </div>
                        <div class="w-full h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-green-500 rounded-lg" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700 text-center">
                    <p class="text-xs text-gray-500 dark:text-slate-400">Overall Conversion</p>
                    <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">3.2%</p>
                </div>
            </div>
        </div>

        <!-- ==================== SOURCES & DEVICES ==================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Traffic Sources -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6">Traffic Sources</h3>
                <div class="flex items-center gap-8">
                    <!-- CSS Donut Chart -->
                    <div class="relative w-32 h-32 shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-100 dark:text-slate-700" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                            <path class="text-violet-500" stroke-dasharray="40, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                            <path class="text-sky-500" stroke-dasharray="25, 100" stroke-dashoffset="-40" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                            <path class="text-pink-500" stroke-dasharray="20, 100" stroke-dashoffset="-65" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                            <path class="text-amber-500" stroke-dasharray="15, 100" stroke-dashoffset="-85" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">124k</span>
                            <span class="text-[9px] text-gray-500 dark:text-slate-400">TOTAL</span>
                        </div>
                    </div>
                    <!-- Legends -->
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span>
                                <span class="text-xs text-gray-600 dark:text-slate-300">Organic Search</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">40%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                                <span class="text-xs text-gray-600 dark:text-slate-300">Social Media</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">25%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                                <span class="text-xs text-gray-600 dark:text-slate-300">Direct Link</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">20%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <span class="text-xs text-gray-600 dark:text-slate-300">Referral</span>
                            </div>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">15%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devices -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6">Devices</h3>
                <div class="space-y-5">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Mobile</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">72%</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 rounded-full" style="width: 72%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Desktop</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">24%</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-sky-500 to-cyan-500 rounded-full" style="width: 24%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-medium text-gray-600 dark:text-slate-300">Tablet</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">4%</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-pink-500 to-rose-500 rounded-full" style="width: 4%"></div>
                        </div>
                    </div>
                </div>

                <!-- Top OS -->
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700 grid grid-cols-2 gap-3">
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">iOS</p>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400">45% Users</p>
                    </div>
                    <div class="text-center p-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Android</p>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400">48% Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== TOP PERFORMING POSTS ==================== -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white">Top Performing Content</h3>
                <button class="text-xs text-violet-600 dark:text-violet-400 font-semibold hover:underline">View All</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Platform</th>
                            <th class="px-6 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Engagement</th>
                            <th class="px-6 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Clicks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">IG</div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Promo Akhir Tahun - Diskon 70%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full">Instagram</span>
                            </td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">45,200</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-green-600 dark:text-green-400">8.2%</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">1,240</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white font-bold text-xs shadow-sm">TT</div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Unboxing Kaos Flanel Premium</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-gradient-to-r from-slate-700 to-slate-900 text-white rounded-full">TikTok</span>
                            </td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">82,500</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-green-600 dark:text-green-400">6.5%</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">980</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">FB</div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Testimoni Pelanggan Setia</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full">Facebook</span>
                            </td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">12,300</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-amber-600 dark:text-amber-400">3.1%</span></td>
                            <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">310</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-4 right-4 z-[100] space-y-2 pointer-events-none"></div>

<style>
    @keyframes toastIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }
    .toast-in { animation: toastIn 0.35s ease-out; }
    .toast-out { animation: toastOut 0.3s ease-in forwards; }
</style>

<script>
    // Chart Tab Switching
    document.querySelectorAll('.chart-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.chart-tab').forEach(t => {
                t.classList.remove('bg-white', 'dark:bg-slate-600', 'text-gray-900', 'dark:text-white', 'shadow-sm');
                t.classList.add('text-gray-500', 'dark:text-slate-400');
            });
            tab.classList.add('bg-white', 'dark:bg-slate-600', 'text-gray-900', 'dark:text-white', 'shadow-sm');
            tab.classList.remove('text-gray-500', 'dark:text-slate-400');
            showToast(`Menampilkan data ${tab.dataset.type}`, 'info');
        });
    });

    // Toast Notification
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-slate-700 dark:bg-slate-600', warning: 'bg-amber-600' };
        const icons = { success: '✓', error: '✕', info: 'ℹ', warning: '⚠' };
        const toast = document.createElement('div');
        toast.className = `pointer-events-auto ${colors[type]} text-white px-4 py-2.5 rounded-xl shadow-2xl text-xs font-medium flex items-center gap-2 toast-in max-w-xs`;
        toast.innerHTML = `<span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0">${icons[type]}</span>${message}`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.remove('toast-in');
            toast.classList.add('toast-out');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Dark mode initiation (if not handled in layout)
    if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>
@endsection
