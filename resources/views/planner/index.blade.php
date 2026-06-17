@extends('layouts.app')

@section('title', 'Content Planner')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white py-6 px-4 md:px-8 transition-colors duration-300" x-data="plannerUI()">

    <!-- Header -->
    <div class="max-w-7xl mx-auto mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-purple-600 to-sky-500 dark:from-purple-400 dark:to-sky-400 bg-clip-text text-transparent">
                Content Planner
            </h1>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Kelola dan jadwalkan konten media sosialmu</p>
        </div>
        <div class="flex gap-3">
            <button @click="showManualModal = true" class="px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-200 rounded-xl text-sm font-semibold hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Manual
            </button>
            <button @click="showAIModal = true" class="px-4 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white rounded-xl text-sm font-bold transition shadow-md shadow-purple-500/20 flex items-center gap-2">
                ✨ Generate AI
                <span class="bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-medium">-5 💎</span>
            </button>
        </div>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-purple-50 dark:bg-purple-500/10 rounded-lg text-purple-600 dark:text-purple-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                <div><p class="text-xs text-gray-500 dark:text-slate-400">Total Ideas</p><p class="text-xl font-bold text-gray-900 dark:text-white">24</p></div>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-sky-50 dark:bg-sky-500/10 rounded-lg text-sky-600 dark:text-sky-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                <div><p class="text-xs text-gray-500 dark:text-slate-400">Scheduled</p><p class="text-xl font-bold text-gray-900 dark:text-white">18</p></div>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-amber-50 dark:bg-amber-500/10 rounded-lg text-amber-600 dark:text-amber-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></div>
                <div><p class="text-xs text-gray-500 dark:text-slate-400">Drafts</p><p class="text-xl font-bold text-gray-900 dark:text-white">6</p></div>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-green-50 dark:bg-green-500/10 rounded-lg text-green-600 dark:text-green-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-xs text-gray-500 dark:text-slate-400">Published</p><p class="text-xl font-bold text-gray-900 dark:text-white">12</p></div>
            </div>
        </div>

        <!-- View Toggles & Filters -->
        <div class="bg-white dark:bg-slate-800 p-3 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex bg-gray-100 dark:bg-slate-900 rounded-lg p-1">
                <button @click="activeView = 'calendar'" :class="activeView === 'calendar' ? 'bg-white dark:bg-slate-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-slate-400'" class="px-4 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Calendar
                </button>
                <button @click="activeView = 'list'" :class="activeView === 'list' ? 'bg-white dark:bg-slate-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-slate-400'" class="px-4 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg> List
                </button>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1 sm:pb-0">
                <button @click="filterPlatform = 'all'" :class="filterPlatform === 'all' ? 'bg-sky-50 dark:bg-sky-500/20 text-sky-600 dark:text-sky-300 border-sky-200 dark:border-sky-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">All</button>
                <button @click="filterPlatform = 'ig'" :class="filterPlatform === 'ig' ? 'bg-pink-50 dark:bg-pink-500/20 text-pink-600 dark:text-pink-300 border-pink-200 dark:border-pink-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">📸 Instagram</button>
                <button @click="filterPlatform = 'tt'" :class="filterPlatform === 'tt' ? 'bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 border-gray-700 dark:border-gray-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">🎵 TikTok</button>
                <button @click="filterPlatform = 'yt'" :class="filterPlatform === 'yt' ? 'bg-red-50 dark:bg-red-500/20 text-red-600 dark:text-red-300 border-red-200 dark:border-red-500/30' : 'bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 border-transparent'" class="px-3 py-1 border rounded-full text-[11px] font-bold transition whitespace-nowrap">▶️ YouTube</button>
            </div>
        </div>

        <!-- Calendar View -->
        <div x-show="activeView === 'calendar'" class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-4 flex justify-between items-center border-b border-gray-100 dark:border-slate-700">
                <h3 class="font-bold text-gray-800 dark:text-slate-200" id="calendarMonthTitle"></h3>
            </div>
            <div class="grid grid-cols-7 bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <div class="px-2 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500">{{ $day }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 bg-gray-50 dark:bg-black/20 gap-px" id="calendarGrid">
                <!-- Injected via JS/PHP for realistic look -->
                @php
                    $now = \Carbon\Carbon::now();
                    $startOfMonth = $now->copy()->startOfMonth();
                    $startDay = $startOfMonth->dayOfWeekIso;
                    $daysInMonth = $now->daysInMonth;
                    $today = $now->day;
                @endphp

                @for ($i = 1; $i < $startDay; $i++)
                    <div class="bg-white dark:bg-slate-800 min-h-[110px] p-2 border-b border-r border-gray-100 dark:border-slate-700/50 opacity-50"></div>
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    <div class="bg-white dark:bg-slate-800 min-h-[110px] p-2 border-b border-r border-gray-100 dark:border-slate-700/50 transition hover:bg-sky-50/50 dark:hover:bg-sky-900/10">
                        <span class="text-xs font-semibold {{ $day == $today ? 'bg-sky-500 text-white px-1.5 py-0.5 rounded-full' : 'text-gray-500 dark:text-slate-400' }}">{{ $day }}</span>

                        <!-- Dummy Content Cards for Representation -->
                        @if($day == 5)
                            <div class="mt-1 p-1.5 bg-gradient-to-r from-pink-500 to-purple-500 rounded text-[9px] text-white font-bold truncate cursor-pointer">📸 IG Reel: OOTD</div>
                        @elseif($day == 12)
                            <div class="mt-1 p-1.5 bg-gray-800 dark:bg-white rounded text-[9px] text-white dark:text-gray-900 font-bold truncate cursor-pointer">🎵 TT: Viral Dance</div>
                        @elseif($day == 18)
                            <div class="mt-1 p-1.5 bg-red-600 rounded text-[9px] text-white font-bold truncate cursor-pointer">▶️ YT: Tutorial</div>
                        @elseif($day == 22)
                            <div class="mt-1 p-1.5 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded text-[9px] font-bold truncate cursor-pointer border border-dashed border-amber-300 dark:border-amber-500/30">📝 Draft: Blog</div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <!-- List View -->
        <div x-show="activeView === 'list'" class="space-y-3">
            <!-- Dummy List Items -->
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-pink-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">IG</div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">5 Cara Mix Match Outfit</h4>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500">📅 Oct 5, 2024 • 📸 Instagram Reels</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-bold bg-sky-100 dark:bg-sky-500/20 text-sky-700 dark:text-sky-300 rounded-full">Scheduled</span>
            </div>
             <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-black dark:bg-white flex items-center justify-center text-white dark:text-black text-xs font-bold">TT</div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Behind The Scene Produk</h4>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500">📅 Oct 12, 2024 • 🎵 TikTok Video</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-bold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full">Draft</span>
            </div>
        </div>

    </div>

    <!-- ===================== MODAL: AI GENERATE ===================== -->
    <div x-show="showAIModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display:none;">
        <div class="absolute inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" @click="showAIModal = false"></div>
        <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 border border-gray-100 dark:border-slate-700 z-10">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">✨ Generate Ide AI</h3>
                <button @click="showAIModal = false" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-white transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('planner.generate') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Niche Bisnis</label>
                        <input type="text" name="niche" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Cth: Cafe, Fashion, Online Course">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Platform Target</label>
                        <select name="platform" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                            <option value="all">Semua Platform</option>
                            <option value="instagram">Instagram (Reels/Post/Story)</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Gaya Bahasa (Tone)</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex items-center gap-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2 cursor-pointer hover:border-purple-300 dark:hover:border-purple-500 transition text-sm">
                                <input type="radio" name="tone" value="profesional" class="accent-purple-500" checked> <span>Profesional</span>
                            </label>
                            <label class="flex items-center gap-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2 cursor-pointer hover:border-purple-300 dark:hover:border-purple-500 transition text-sm">
                                <input type="radio" name="tone" value="santai" class="accent-purple-500"> <span>Santai</span>
                            </label>
                            <label class="flex items-center gap-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2 cursor-pointer hover:border-purple-300 dark:hover:border-purple-500 transition text-sm">
                                <input type="radio" name="tone" value="lucu" class="accent-purple-500"> <span>Lucu</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Target Audience (Opsional)</label>
                        <input type="text" name="audience" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Cth: Remaja, Pekerja Kantoran">
                    </div>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-2">
                    <button type="button" @click="showAIModal = false" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg font-bold shadow-md hover:from-purple-500 hover:to-purple-600 transition flex justify-center items-center gap-2">
                        Generate (5 💎)
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== MODAL: ADD MANUAL ===================== -->
    <div x-show="showManualModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display:none;">
        <div class="absolute inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" @click="showManualModal = false"></div>
        <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 border border-gray-100 dark:border-slate-700 z-10">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">📝 Add Manual</h3>
                <button @click="showManualModal = false" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-white transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('planner.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Judul Konten</label>
                        <input type="text" name="title" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="Cth: Review Produk Terbaru">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Tanggal</label>
                            <input type="date" name="date" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Platform</label>
                            <select name="platform" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                                <option value="ig">Instagram</option>
                                <option value="tt">TikTok</option>
                                <option value="yt">YouTube</option>
                                <option value="tw">Twitter/X</option>
                                <option value="fb">Facebook</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Caption / Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition resize-none" placeholder="Tulis deskripsi atau caption..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-2">
                    <button type="button" @click="showManualModal = false" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-sky-600 hover:bg-sky-500 text-white rounded-lg font-bold shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div x-show="showToast" x-transition class="fixed bottom-6 right-6 bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-bold z-[60]">
        <span x-text="toastMsg"></span>
    </div>

</div>

<script>
function plannerUI() {
    return {
        showAIModal: false,
        showManualModal: false,
        activeView: 'calendar',
        filterPlatform: 'all',
        showToast: false,
        toastMsg: '',

        init() {
            // Check if there's an error session to show modal again
            @if(session('error'))
                this.showAIModal = true;
                this.toastMsg = '{{ session('error') }}';
                this.showToast = true;
                setTimeout(() => this.showToast = false, 3000);
            @endif
        }
    }
}
</script>
@endsection
