@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 transition-colors duration-500">
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <!-- ==================== HERO & SEARCH ==================== -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">Marketplace Template</h1>
            <p class="text-gray-500 dark:text-slate-400 max-w-xl mx-auto mb-6">Temukan template caption, gambar, dan video profesional untuk meningkatkan penjualan bisnis Anda.</p>

            <div class="max-w-2xl mx-auto relative">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Cari template (contoh: promosi ramadhan, video unboxing)..." class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 dark:text-white shadow-sm transition">
            </div>
        </div>

        <!-- ==================== FILTERS & SORT ==================== -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <!-- Category Filters -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 custom-scroll">
                <button onclick="setFilter('all')" class="filter-btn active shrink-0 px-4 py-2 text-xs font-semibold rounded-xl bg-sky-600 text-white shadow-sm transition-all" data-filter="all">Semua</button>
                <button onclick="setFilter('caption')" class="filter-btn shrink-0 px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-700 hover:border-sky-300 transition-all" data-filter="caption">📝 Caption</button>
                <button onclick="setFilter('image')" class="filter-btn shrink-0 px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-700 hover:border-sky-300 transition-all" data-filter="image">🎨 Image</button>
                <button onclick="setFilter('video')" class="filter-btn shrink-0 px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-700 hover:border-sky-300 transition-all" data-filter="video">🎬 Video</button>
            </div>

            <!-- Sort & View Toggle -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select class="flex-1 md:flex-none appearance-none bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl px-4 py-2 text-xs font-medium text-gray-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option>Terbaru</option>
                    <option>Terlaris</option>
                    <option>Harga Terendah</option>
                    <option>Harga Tertinggi</option>
                </select>
            </div>
        </div>

        <!-- ==================== GRID PRODUK ==================== -->
        <div id="templateGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            @forelse ($templates as $template)
                <!-- Card Produk -->
                <div class="template-card group bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-type="{{ $template->type }}" data-title="{{ strtolower($template->title) }}">

                    <!-- Thumbnail Area -->
                    <div class="relative h-44 bg-gray-200 dark:bg-slate-700 bg-cover bg-center overflow-hidden">
                        <img src="{{ $template->thumbnail ? asset('storage/'.$template->thumbnail) : 'https://via.placeholder.com/400x300/1e293b/94a3b8?text=No+Preview' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $template->title }}">

                        <!-- Type Badge Floating -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-lg shadow-sm
                                {{ $template->type == 'video' ? 'bg-red-500 text-white' : ($template->type == 'image' ? 'bg-emerald-500 text-white' : 'bg-sky-500 text-white') }}">
                                {{ $template->type == 'video' ? '🎬 Video' : ($template->type == 'image' ? '🎨 Image' : '📝 Caption') }}
                            </span>
                        </div>

                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-4">
                            <a href="{{ route('marketplace.show', $template->id) }}" class="px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-xl hover:bg-sky-500 hover:text-white transition-colors shadow-lg">
                                Quick View
                            </a>
                            <button onclick="event.preventDefault(); toggleBookmark(this)" class="p-2 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/40 transition-colors">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white truncate group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">
                            {{ $template->title }}
                        </h3>

                        <!-- Author & Rating -->
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-1.5">
                                <div class="w-5 h-5 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white text-[8px] font-bold">
                                    {{ strtoupper(substr($template->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-500 dark:text-slate-400">{{ $template->user->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-300">4.8</span>
                            </div>
                        </div>

                        <!-- Price & Buy Button -->
                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex justify-between items-center">
                            <span class="text-lg font-extrabold text-gray-900 dark:text-white flex items-center gap-1">
                                <span class="text-sky-500 text-sm">💎</span> {{ $template->price ?? 0 }}
                            </span>
                            <form action="{{ route('marketplace.buy', $template->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 text-xs font-bold rounded-xl hover:bg-sky-600 hover:text-white transition-colors active:scale-95">
                                    Beli
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700">
                    <div class="text-5xl mb-4">📦</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Template</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Template marketplace sedang dalam persiapan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $templates->links() }}
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
    // Filter Functionality
    function setFilter(type) {
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if(btn.dataset.filter === type) {
                btn.classList.add('bg-sky-600', 'text-white', 'shadow-sm');
                btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-gray-600', 'dark:text-slate-300', 'border', 'border-gray-200', 'dark:border-slate-700');
            } else {
                btn.classList.remove('bg-sky-600', 'text-white', 'shadow-sm');
                btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-gray-600', 'dark:text-slate-300', 'border', 'border-gray-200', 'dark:border-slate-700');
            }
        });

        // Filter cards
        const cards = document.querySelectorAll('.template-card');
        cards.forEach(card => {
            if(type === 'all' || card.dataset.type === type) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Search Functionality
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.template-card');
        cards.forEach(card => {
            const title = card.dataset.title;
            card.style.display = title.includes(searchTerm) ? 'block' : 'none';
        });
    });

    // Bookmark Toggle
    function toggleBookmark(btn) {
        const svg = btn.querySelector('svg');
        if(svg.getAttribute('fill') === 'none') {
            svg.setAttribute('fill', 'currentColor');
            showToast('Ditambahkan ke Wishlist', 'success');
        } else {
            svg.setAttribute('fill', 'none');
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
