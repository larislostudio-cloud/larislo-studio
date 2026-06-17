@extends('layouts.app')

@section('title', 'Detail Template')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 transition-colors duration-500">
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

        @if(isset($template))
        <!-- Breadcrumbs -->
        <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400">
            <a href="{{ route('marketplace.index') }}" class="hover:text-sky-600 dark:hover:text-sky-400 transition">Marketplace</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 dark:text-white font-medium truncate">{{ $template->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <!-- ==================== LEFT: PREVIEW AREA ==================== -->
            <div class="lg:col-span-3 space-y-4">
                <!-- Main Preview Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    @if($template->type == 'caption')
                        <!-- Caption Preview -->
                        <div class="p-6 md:p-8 bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 min-h-[300px] relative border-b border-gray-100 dark:border-slate-600">
                            <button onclick="copyCaption()" class="absolute top-4 right-4 px-3 py-1.5 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-sky-900/30 hover:text-sky-600 transition flex items-center gap-1.5 active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                <span id="copyBtnText">Copy Caption</span>
                            </button>
                            <div id="captionContent" class="text-gray-800 dark:text-slate-200 whitespace-pre-wrap leading-relaxed text-sm md:text-base font-medium">
                                {{ $template->description }}
                            </div>
                        </div>
                    @else
                        <!-- Image/Video Preview -->
                        <div class="relative group">
                            <img src="{{ $template->thumbnail ? asset('storage/'.$template->thumbnail) : 'https://via.placeholder.com/800x500/1e293b/94a3b8?text=Preview' }}" class="w-full h-auto object-cover max-h-[500px]" alt="{{ $template->title }}">
                            @if($template->type == 'video')
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/50 transition-colors">
                                    <div class="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-sky-600 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Description / Details Tabs -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex border-b border-gray-100 dark:border-slate-700 mb-4">
                        <button class="text-sm font-semibold text-sky-600 dark:text-sky-400 pb-3 border-b-2 border-sky-600 mr-6">Deskripsi</button>
                        <button class="text-sm font-semibold text-gray-400 dark:text-slate-500 pb-3 hover:text-gray-600 transition">Ulasan (12)</button>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed">
                        {{ $template->description }}
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 text-xs font-medium rounded-full">Marketing</span>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 text-xs font-medium rounded-full">Promo</span>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 text-xs font-medium rounded-full">Ramadhan</span>
                    </div>
                </div>
            </div>

            <!-- ==================== RIGHT: PURCHASE SIDEBAR ==================== -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Main Info & Action -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-24">

                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-lg {{ $template->type == 'video' ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' : ($template->type == 'image' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400') }}">
                        {{ $template->type }}
                    </span>

                    <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-3 leading-tight">{{ $template->title }}</h1>

                    <!-- Author -->
                    <div class="flex items-center gap-3 mt-4 pb-4 border-b border-gray-100 dark:border-slate-700">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr($template->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $template->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">Penjual Terverifikasi</p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-2 py-4 border-b border-gray-100 dark:border-slate-700">
                        <div class="text-center">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $template->views }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-slate-400">Views</p>
                        </div>
                        <div class="text-center border-x border-gray-100 dark:border-slate-700">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">150</p>
                            <p class="text-[10px] text-gray-500 dark:text-slate-400">Terjual</p>
                        </div>
                        <div class="text-center flex flex-col items-center">
                            <div class="flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">4.8</span>
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-slate-400">Rating</p>
                        </div>
                    </div>

                    <!-- Price & Action -->
                    <div class="mt-6">
                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">Harga</p>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="text-sky-500 text-xl">💎</span> {{ $template->price ?? 0 }}
                            </span>
                            <span class="text-xs font-bold text-gray-400 line-through ml-1">💎 {{ intval($template->price * 1.5 ?? 0) }}</span>
                        </div>

                        @auth
                            <form action="{{ route('marketplace.buy', $template->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-sky-600 to-cyan-500 hover:from-sky-700 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg shadow-sky-500/25 transition-all active:scale-95 flex items-center justify-center gap-2 mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                    Beli Sekarang
                                </button>
                            </form>
                            <button onclick="toggleBookmark(this)" class="w-full py-3 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Tambah ke Wishlist
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="w-full py-3.5 bg-gradient-to-r from-sky-600 to-cyan-500 text-white font-bold rounded-xl shadow-lg shadow-sky-500/25 flex items-center justify-center gap-2 mb-3">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>

                    <!-- Features -->
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700 space-y-3">
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">Fitur Template</h4>
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Lisensi Komersial
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Siap Pakai & Editable
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Gratis Selamanya
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
            <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700">
                <div class="text-5xl mb-4">🤷‍♂️</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Template Tidak Ditemukan</h3>
                <a href="{{ route('marketplace.index') }}" class="text-sm text-sky-600 dark:text-sky-400 mt-2 inline-block hover:underline">Kembali ke Marketplace</a>
            </div>
        @endif
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
    // Copy Caption Logic (For text type)
    function copyCaption() {
        const captionText = document.getElementById('captionContent').innerText;
        navigator.clipboard.writeText(captionText).then(() => {
            const btn = document.getElementById('copyBtnText');
            btn.innerText = 'Copied!';
            showToast('Caption berhasil disalin!', 'success');
            setTimeout(() => btn.innerText = 'Copy Caption', 2000);
        });
    }

    // Bookmark Toggle
    function toggleBookmark(btn) {
        const svg = btn.querySelector('svg');
        if(svg.getAttribute('fill') === 'none') {
            svg.setAttribute('fill', 'currentColor');
            btn.classList.add('border-red-200', 'dark:border-red-800', 'text-red-500');
            btn.classList.remove('border-gray-200', 'dark:border-slate-700', 'text-gray-700', 'dark:text-slate-300');
            showToast('Ditambahkan ke Wishlist ❤️', 'success');
        } else {
            svg.setAttribute('fill', 'none');
            btn.classList.remove('border-red-200', 'dark:border-red-800', 'text-red-500');
            btn.classList.add('border-gray-200', 'dark:border-slate-700', 'text-gray-700', 'dark:text-slate-300');
            showToast('Dihapus dari Wishlist', 'info');
        }
    }

    // Toast Notification
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-slate-700', warning: 'bg-amber-600' };
        const icons = { success: '✓', error: '✕', info: 'ℹ', warning: '⚠' };
        const toast = document.createElement('div');
        toast.className = `pointer-events-auto ${colors[type]} text-white px-4 py-2.5 rounded-xl shadow-2xl text-xs font-medium flex items-center gap-2 toast-in max-w-xs`;
        toast.innerHTML = `<span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0">${icons[type]}</span>${message}`;
        container.appendChild(toast);
        setTimeout(() => { toast.classList.remove('toast-in'); toast.classList.add('toast-out'); setTimeout(() => toast.remove(), 300); }, 3000);
    }
</script>
@endsection
