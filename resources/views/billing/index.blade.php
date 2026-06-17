@extends('layouts.app')

@section('title', 'Beli Kredit')

@section('content')
<div class="py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ==================== CARD SALDO KREDIT ==================== -->
        <div class="relative bg-gradient-to-br from-sky-500 to-blue-700 dark:from-sky-700 dark:to-blue-900 rounded-3xl shadow-2xl p-8 text-white mb-12 overflow-hidden">
            <!-- Dekorasi Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-16 -mb-16 blur-xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <p class="text-sky-100 text-sm uppercase font-bold tracking-wider">Saldo Kredit Anda</p>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-extrabold tracking-tight">{{ auth()->user()->credits ?? 0 }}</h2>
                    <p class="text-sky-200 text-sm mt-2">Kredit tidak pernah hangus dan berlaku selamanya.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 px-5 py-3 rounded-2xl text-left md:text-right">
                    <p class="text-sky-100 text-xs uppercase font-semibold">Bonus Harian 🎁</p>
                    <p class="text-xl font-extrabold mt-1">+3 Kredit/Hari</p>
                    <p class="text-[10px] text-sky-300 mt-1">Klaim otomatis saat login</p>
                </div>
            </div>
        </div>

        <!-- ==================== NOTIFIKASI ==================== -->
        @if(session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 p-4 rounded-xl mb-8 flex items-center gap-3 shadow-sm">
                <span class="text-2xl">✅</span>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <!-- ==================== HEADER LIST ==================== -->
        <div class="text-center mb-10">
            <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Pilih Paket Kredit</h3>
            <p class="text-gray-500 dark:text-slate-400 mt-2 max-w-xl mx-auto">Investasi sekali, gunakan kapan saja. Semakin besar paket, semakin besar bonus yang didapat.</p>
        </div>

        <!-- ==================== GRID PAKET KREDIT ==================== -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($packages as $package)
                @php
                    // Logika sederhana untuk menandai paket "Best Value" (misal bonus > 50)
                    $isPopular = $package->bonus >= 50;
                @endphp

                <div class="relative bg-white dark:bg-slate-800 border {{ $isPopular ? 'border-sky-500 dark:border-sky-400 ring-2 ring-sky-500/20' : 'border-gray-100 dark:border-slate-700' }} rounded-2xl overflow-hidden hover:shadow-2xl dark:hover:shadow-slate-900/50 hover:-translate-y-2 transition-all duration-300 flex flex-col group">

                    @if($isPopular)
                        <div class="absolute top-0 left-0 right-0 bg-sky-500 dark:bg-sky-600 text-white text-center text-[10px] font-black uppercase tracking-widest py-1">
                            Best Value 🔥
                        </div>
                    @endif

                    <div class="p-6 flex-1 flex flex-col {{ $isPopular ? 'pt-8' : '' }}">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $package->name }}</h4>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Cocok untuk bisnis {{ $package->bonus > 50 ? 'skala besar' : 'pemula' }}</p>

                        <div class="my-6 flex-grow">
                            <span class="text-5xl font-extrabold {{ $isPopular ? 'text-sky-600 dark:text-sky-400' : 'text-gray-900 dark:text-white' }}">{{ $package->total_credits }}</span>
                            <span class="text-gray-400 dark:text-slate-500 text-sm ml-1 font-semibold">Kredit</span>
                        </div>

                        @if($package->bonus > 0)
                            <div class="inline-flex items-center gap-1.5 self-start bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                +{{ $package->bonus }} Bonus
                            </div>
                        @endif
                    </div>

                    <!-- BAGIAN HARGA & TOMBOL -->
                    <div class="p-6 bg-gray-50 dark:bg-slate-800/50 border-t {{ $isPopular ? 'border-sky-100 dark:border-sky-900/50' : 'border-gray-100 dark:border-slate-700' }}">
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white mb-1">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        @if($package->total_credits > 0)
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 mb-4">≈ Rp {{ number_format($package->price / $package->total_credits, 0, ',', '.') }} / kredit</p>
                        @else
                            <div class="mb-4"></div>
                        @endif

                        <form action="{{ route('billing.buy', $package->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-center py-2.5 rounded-xl font-bold transition-all duration-200 active:scale-95 {{ $isPopular ? 'bg-sky-600 hover:bg-sky-700 text-white shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50' : 'bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:border-sky-500 hover:text-sky-600 dark:hover:border-sky-400 dark:hover:text-sky-400' }}">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ==================== INFO TAMBAHAN ==================== -->
        <div class="mt-12 bg-gray-50 dark:bg-slate-800/50 border border-gray-100 dark:border-slate-700 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-sky-100 dark:bg-sky-900/30 rounded-xl flex items-center justify-center text-sky-600 dark:text-sky-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">Pembayaran Aman & Terenkripsi</h4>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Kami mendukung transfer bank, e-wallet, dan kartu kredit via gateway terpercaya.</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tanpa Kadaluarsa</span>
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Instan Proses</span>
            </div>
        </div>

    </div>
</div>
@endsection
