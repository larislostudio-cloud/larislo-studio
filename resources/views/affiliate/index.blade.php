@extends('layouts.app')

@section('title', 'Affiliate Tools')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 transition-colors duration-500">
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <!-- ==================== HEADER ==================== -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 bg-gradient-to-br from-sky-500 to-cyan-400 rounded-lg flex items-center justify-center text-white text-sm">💰</span>
                    Affiliate Hub
                </h1>
                <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Monetisasi jaringan Anda dengan membagikan link produk viral.</p>
            </div>
            <button onclick="showToast('Permintaan pencairan diajukan!', 'success')" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-sky-600 to-cyan-500 hover:from-sky-700 hover:to-cyan-600 text-white rounded-xl font-semibold shadow-lg shadow-sky-500/25 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tarik Dana
            </button>
        </div>

        <!-- ==================== STATS GRID ==================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Card: Saldo -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-500/10 rounded-full -mr-5 -mt-5 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Saldo Tersedia</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp 1.250.000</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +Rp 350.000 bulan ini
                    </p>
                </div>
            </div>

            <!-- Card: Klik -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-sky-500/10 rounded-full -mr-5 -mt-5 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-sky-100 dark:bg-sky-900/30 rounded-lg flex items-center justify-center text-sky-600 dark:text-sky-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Klik</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">8,432</p>
                    <p class="text-xs text-sky-600 dark:text-sky-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +520 minggu ini
                    </p>
                </div>
            </div>

            <!-- Card: Konversi -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-full -mr-5 -mt-5 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Konversi</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">4.8%</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +0.5% dari bulan lalu
                    </p>
                </div>
            </div>

            <!-- Card: Link Aktif -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/10 rounded-full -mr-5 -mt-5 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-slate-400">Link Aktif</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">12</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">Dari 15 total link</p>
                </div>
            </div>
        </div>

        <!-- ==================== GENERATE LINK ==================== -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 mb-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 bg-sky-100 dark:bg-sky-900/30 rounded-lg flex items-center justify-center text-sky-600 dark:text-sky-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Generate Link Affiliate</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400">Buat link tracking dan bagikan ke audiens Anda</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1.5 block">URL Produk</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            <input type="text" id="urlInput" placeholder="https://tokopedia.com/product/..." class="w-full pl-9 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 dark:text-white transition">
                        </div>
                        <button onclick="generateLink()" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-semibold text-sm shadow-lg shadow-sky-500/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Generate
                        </button>
                    </div>
                </div>

                <!-- Advanced Options Toggle -->
                <button onclick="toggleAdvanced()" class="flex items-center gap-2 text-xs font-medium text-sky-600 dark:text-sky-400 hover:text-sky-700 transition">
                    <svg id="advIcon" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Opsi Lanjutan (UTM & Custom Slug)
                </button>

                <div id="advancedOptions" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1.5 block">Custom Slug</label>
                        <div class="flex items-center bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl overflow-hidden">
                            <span class="px-3 py-2.5 bg-gray-100 dark:bg-slate-600 border-r border-gray-200 dark:border-slate-500 text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">loris.id/</span>
                            <input type="text" id="slugInput" placeholder="promo-kaos-viral" class="flex-1 px-3 py-2.5 bg-transparent text-sm focus:outline-none dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1.5 block">UTM Source (Opsional)</label>
                        <input type="text" id="utmInput" placeholder="tiktok, instagram, dll" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 dark:text-white transition">
                    </div>
                </div>

                <!-- Result Box -->
                <div id="resultBox" class="hidden p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Link Affiliate Berhasil Dibuat</p>
                            <p id="resultLink" class="text-sm font-mono font-semibold text-emerald-800 dark:text-emerald-200 truncate">https://loris.id/promo-kaos-viral</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button onclick="copyLink()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                <span id="copyBtnText">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== PERFORMANCE CHART ==================== -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 mb-8">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 dark:text-white">Statistik Klik (7 Hari Terakhir)</h3>
                <div class="flex items-center gap-1 bg-gray-100 dark:bg-slate-700 rounded-lg p-0.5">
                    <button class="px-3 py-1 text-xs font-medium rounded-md bg-white dark:bg-slate-600 text-gray-900 dark:text-white shadow-sm transition">Klik</button>
                    <button class="px-3 py-1 text-xs font-medium rounded-md text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 transition">Komisi</button>
                </div>
            </div>
            <div class="flex items-end gap-2 h-32">
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-400 dark:bg-sky-500 rounded-t-md transition-all hover:bg-sky-500 dark:hover:bg-sky-400" style="height: 40%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Sen</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-400 dark:bg-sky-500 rounded-t-md transition-all hover:bg-sky-500 dark:hover:bg-sky-400" style="height: 70%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Sel</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-400 dark:bg-sky-500 rounded-t-md transition-all hover:bg-sky-500 dark:hover:bg-sky-400" style="height: 50%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Rab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-400 dark:bg-sky-500 rounded-t-md transition-all hover:bg-sky-500 dark:hover:bg-sky-400" style="height: 85%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Kam</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-400 dark:bg-sky-500 rounded-t-md transition-all hover:bg-sky-500 dark:hover:bg-sky-400" style="height: 65%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Jum</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-300 dark:bg-sky-600 rounded-t-md transition-all hover:bg-sky-400" style="height: 100%"></div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Sab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-sky-500 dark:bg-sky-400 rounded-t-md animate-pulse" style="height: 45%"></div>
                    <span class="text-[10px] text-sky-500 font-bold">Min</span>
                </div>
            </div>
        </div>

        <!-- ==================== LINKS TABLE ==================== -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-8">
            <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h3 class="font-bold text-gray-900 dark:text-white">Riwayat Link Affiliate</h3>
                <div class="relative w-full sm:w-64">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari link atau produk..." class="w-full pl-9 pr-4 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-sky-500 dark:text-white transition">
                </div>
            </div>

            <div class="overflow-x-auto custom-scroll">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Produk / Link</th>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Klik</th>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Konversi</th>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Komisi</th>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        <!-- Item 1 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">KT</div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Kaos Polos Viral</p>
                                        <p class="text-xs text-sky-600 dark:text-sky-400 font-mono">loris.id/kaos-viral</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">3,450</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-green-600 dark:text-green-400">5.2%</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">Rp 520.000</span></td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full uppercase">Active</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="copyToClipboard('loris.id/kaos-viral')" class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-600 rounded-lg transition" title="Copy Link">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                </button>
                                <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-600 rounded-lg transition" title="Analytics">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Item 2 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">KM</div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Kemeja Flanel Premium</p>
                                        <p class="text-xs text-sky-600 dark:text-sky-400 font-mono">loris.id/flanel-prem</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">1,200</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-amber-600 dark:text-amber-400">3.1%</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">Rp 480.000</span></td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full uppercase">Active</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="copyToClipboard('loris.id/flanel-prem')" class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-600 rounded-lg transition" title="Copy Link">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                </button>
                                <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-600 rounded-lg transition" title="Analytics">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Item 3 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">SB</div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Sepatu Boots Kulit</p>
                                        <p class="text-xs text-gray-400 dark:text-slate-500 font-mono line-through">loris.id/boots-kulit</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">120</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-red-600 dark:text-red-400">0.8%</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 dark:text-white">Rp 0</span></td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full uppercase">Expired</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-600 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-3">
                <p class="text-xs text-gray-500 dark:text-slate-400">Menampilkan 1-3 dari 12 link</p>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition">Prev</button>
                    <button class="px-3 py-1.5 text-xs font-medium bg-sky-600 text-white rounded-lg shadow-sm">1</button>
                    <button class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition">2</button>
                    <button class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition">Next</button>
                </div>
            </div>
        </div>

        <!-- ==================== MARKETING TIPS ==================== -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="p-5 bg-gradient-to-r from-sky-600 to-cyan-500 rounded-2xl shadow-lg shadow-sky-500/20 text-white flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl shrink-0">💡</div>
                <div>
                    <h4 class="font-bold text-sm">Tips: Konten Story Viral</h4>
                    <p class="text-sky-100 text-xs mt-1 leading-relaxed">Gunakan hook 3 detik pertama di story IG/TikTok. Tunjukkan masalah lalu berikan solusi produk Anda. Masukkan link di bio!</p>
                </div>
            </div>
            <div class="p-5 bg-gradient-to-r from-violet-600 to-purple-500 rounded-2xl shadow-lg shadow-violet-500/20 text-white flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl shrink-0">📈</div>
                <div>
                    <h4 class="font-bold text-sm">Promo Eksklusif Affiliate</h4>
                    <p class="text-purple-100 text-xs mt-1 leading-relaxed">Diskon 20% untuk pembeli dari link Anda minggu ini! Segera bagikan link sebelum kuota habis.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-4 right-4 z-[100] space-y-2 pointer-events-none"></div>

<style>
    .custom-scroll::-webkit-scrollbar { height: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }
    .dark .custom-scroll::-webkit-scrollbar-thumb { background: #475569; }

    @keyframes toastIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }
    .toast-in { animation: toastIn 0.35s ease-out; }
    .toast-out { animation: toastOut 0.3s ease-in forwards; }
</style>

<script>
    function toggleAdvanced() {
        const options = document.getElementById('advancedOptions');
        const icon = document.getElementById('advIcon');
        if(options.classList.contains('hidden')) {
            options.classList.remove('hidden');
            options.classList.add('grid');
            icon.style.transform = 'rotate(180deg)';
        } else {
            options.classList.add('hidden');
            options.classList.remove('grid');
            icon.style.transform = 'rotate(0deg)';
        }
    }

    function generateLink() {
        const url = document.getElementById('urlInput').value;
        const slug = document.getElementById('slugInput').value || Math.random().toString(36).substring(2, 8);
        const utm = document.getElementById('utmInput').value;

        if (!url) {
            showToast('Masukkan URL produk terlebih dahulu!', 'error');
            return;
        }

        const resultBox = document.getElementById('resultBox');
        const resultLink = document.getElementById('resultLink');

        // Simulate generation
        const fullLink = `https://loris.id/${slug}${utm ? '?utm_source='+utm : ''}`;

        resultLink.innerText = fullLink;
        resultBox.classList.remove('hidden');
        showToast('Link affiliate berhasil digenerate!', 'success');
    }

    function copyLink() {
        const linkText = document.getElementById('resultLink').innerText;
        navigator.clipboard.writeText(linkText).then(() => {
            const btnText = document.getElementById('copyBtnText');
            btnText.innerText = 'Copied!';
            showToast('Link berhasil disalin!', 'success');
            setTimeout(() => btnText.innerText = 'Copy', 2000);
        });
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText('https://' + text).then(() => {
            showToast('Link berhasil disalin!', 'success');
        });
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-slate-700', warning: 'bg-amber-600' };
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

    // Dark mode initiation (if not already handled in layout)
    if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>
@endsection
