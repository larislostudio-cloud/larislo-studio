@extends('layouts.app')

@section('title', 'AI Caption Generator')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 py-8 px-4 sm:px-6 lg:px-8 transition-colors duration-300" x-data="captionGenerator({{ auth()->user()->credits }})">

    <!-- Header & Credits -->
    <div class="max-w-6xl mx-auto mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                ✍️ <span class="bg-gradient-to-r from-sky-500 to-blue-600 dark:from-sky-400 dark:to-blue-500 bg-clip-text text-transparent">AI Caption</span> Studio
            </h1>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Buat caption viral & menarik dalam hitungan detik</p>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 px-5 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <div class="text-sky-500 dark:text-sky-400 text-xl">💎</div>
            <div>
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400">Saldo</p>
                <p class="font-extrabold text-lg text-gray-900 dark:text-white leading-tight">{{ auth()->user()->credits }} <span class="text-xs font-medium text-gray-400 dark:text-slate-500">Kredit</span></p>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- KIRI: Form Input -->
        <div class="lg:col-span-3 space-y-6">

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-300 p-4 rounded-xl flex items-start gap-3">
                    <span class="text-red-500 text-lg mt-0.5">⚠️</span>
                    <div>
                        <p class="font-semibold text-sm">Gagal Menghasilkan</p>
                        <p class="text-xs mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(auth()->user()->credits < 1)
                <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 p-4 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-red-500 text-xl">🚫</span>
                        <div>
                            <p class="font-bold text-red-700 dark:text-red-300 text-sm">Kredit Habis</p>
                            <p class="text-xs text-red-500 dark:text-red-400">Isi ulang untuk melanjutkan membuat caption.</p>
                        </div>
                    </div>
                    <a href="{{ route('billing.index') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition shadow-sm">Beli Kredit</a>
                </div>
            @endif

            <form action="{{ route('ai.caption.generate') }}" method="POST" id="captionForm" class="space-y-6">
                @csrf

                <!-- Info Dasar -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">📦 Detail Produk</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Nama Produk</label>
                            <input type="text" name="product_name" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Contoh: Kopi Susu Gula Aren">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Jenis Bisnis</label>
                                <input type="text" name="business_type" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Contoh: F&B, Fashion">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Target Pasar</label>
                                <input type="text" name="target_market" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Contoh: Gen Z, Pelajar">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Promo / Highlight (Opsional)</label>
                            <input type="text" name="promo" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Contoh: Diskon 20% hanya hari ini">
                        </div>
                    </div>
                </div>

                <!-- Pengaturan -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm space-y-6">

                    <!-- Platform -->
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 mb-3 uppercase tracking-wider">Platform</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button type="button" @click="platform = 'instagram'" :class="platform === 'instagram' ? 'border-pink-500 bg-pink-50 dark:bg-pink-500/10 text-pink-600 dark:text-pink-300 shadow-sm' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-3 flex flex-col items-center gap-1.5 transition font-medium text-xs">
                                📸 <span>Instagram</span>
                            </button>
                            <button type="button" @click="platform = 'tiktok'" :class="platform === 'tiktok' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300 shadow-sm' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-3 flex flex-col items-center gap-1.5 transition font-medium text-xs">
                                🎵 <span>TikTok</span>
                            </button>
                            <button type="button" @click="platform = 'twitter'" :class="platform === 'twitter' ? 'border-blue-500 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-300 shadow-sm' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-3 flex flex-col items-center gap-1.5 transition font-medium text-xs">
                                𝕏 <span>Twitter/X</span>
                            </button>
                            <button type="button" @click="platform = 'facebook'" :class="platform === 'facebook' ? 'border-blue-600 bg-blue-50 dark:bg-blue-600/10 text-blue-700 dark:text-blue-300 shadow-sm' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-3 flex flex-col items-center gap-1.5 transition font-medium text-xs">
                                👍 <span>Facebook</span>
                            </button>
                        </div>
                        <input type="hidden" name="platform" x-model="platform">
                    </div>

                    <!-- Tone -->
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 mb-3 uppercase tracking-wider">Gaya Bahasa (Tone)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button type="button" @click="tone = 'santai'" :class="tone === 'santai' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-2.5 text-xs font-medium transition">😎 Santai</button>
                            <button type="button" @click="tone = 'profesional'" :class="tone === 'profesional' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-2.5 text-xs font-medium transition">👔 Profesional</button>
                            <button type="button" @click="tone = 'lucu'" :class="tone === 'lucu' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-2.5 text-xs font-medium transition">😂 Lucu</button>
                            <button type="button" @click="tone = 'gokil'" :class="tone === 'gokil' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300' : 'border-gray-200 dark:border-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700'" class="border rounded-lg p-2.5 text-xs font-medium transition">🔥 Gokil</button>
                        </div>
                        <input type="hidden" name="tone" x-model="tone">
                    </div>

                    <!-- Emoji Level -->
                    <div>
                        <label class="flex justify-between text-xs font-bold text-gray-600 dark:text-slate-400 mb-2 uppercase tracking-wider">
                            <span>Intensitas Emoji</span>
                            <span class="text-sky-500 normal-case" x-text="emojiLevelLabel"></span>
                        </label>
                        <input type="range" x-model="emojiLevel" min="0" max="2" step="1" class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-sky-500">
                        <input type="hidden" name="emoji_level" x-model="emojiLevel">
                    </div>

                    <!-- Include Hashtag -->
                    <label class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 cursor-pointer">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-700 dark:text-slate-300 text-sm font-medium"># Sertakan Hashtag</span>
                            <span class="text-[10px] bg-gray-200 dark:bg-slate-700 text-gray-500 dark:text-slate-400 px-1.5 py-0.5 rounded">Boost SEO</span>
                        </div>
                        <div class="relative">
                            <input type="checkbox" x-model="includeHashtags" class="sr-only" name="include_hashtags">
                            <div class="w-10 h-4 bg-gray-300 dark:bg-slate-600 rounded-full shadow-inner transition" :class="includeHashtags ? 'bg-sky-500 dark:bg-sky-400' : ''"></div>
                            <div class="absolute left-0.5 top-0.5 w-3 h-3 bg-white rounded-full shadow transition-transform" :class="includeHashtags ? 'translate-x-6' : ''"></div>
                        </div>
                    </label>

                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-sky-500 to-blue-600 dark:from-sky-400 dark:to-blue-500 text-white py-3.5 rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-sky-500/20 hover:shadow-sky-500/40 disabled:opacity-40 disabled:cursor-not-allowed"
                    :disabled="credits < 1 || isGenerating">

                    <div x-show="!isGenerating" class="flex items-center gap-2">
                        <span>Buat Caption</span>
                        <span class="bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-semibold">-1 💎</span>
                    </div>

                    <div x-show="isGenerating" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Sedang Membuat...</span>
                    </div>
                </button>

            </form>
        </div>

        <!-- KANAN: Hasil -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden sticky top-24">
                <div class="p-4 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">📝 Hasil</h3>
                    @if(session('result'))
                        <button @click="copyText" class="text-xs px-3 py-1.5 bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-300 rounded-lg font-medium hover:bg-sky-100 dark:hover:bg-sky-500/20 transition flex items-center gap-1.5">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <svg x-show="copied" class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                        </button>
                    @endif
                </div>

                <div class="p-5 min-h-[300px] flex flex-col">
                    @if(session('result'))
                        <div class="flex-1 bg-gray-50 dark:bg-slate-900 p-4 rounded-lg border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-slate-200 text-sm leading-relaxed whitespace-pre-wrap">
                            {{ session('result') }}
                        </div>
                        <input type="hidden" id="captionResult" value="{{ session('result') }}">
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-8">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center text-3xl mb-4">✨</div>
                            <h4 class="font-bold text-gray-700 dark:text-slate-300 mb-1">Caption Anda menunggu</h4>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">Isi formulir lalu klik "Buat Caption" untuk melihat hasilnya di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function captionGenerator(initialCredits) {
    return {
        credits: initialCredits,
        platform: 'instagram',
        tone: 'santai',
        emojiLevel: 1,
        includeHashtags: true,
        isGenerating: false,
        copied: false,

        get emojiLevelLabel() {
            switch(this.emojiLevel) {
                case '0': return '🚫 Tanpa Emoji';
                case '1': return '😊 Halus';
                case '2': return '🤩 Ekstra';
                default: return '😊 Halus';
            }
        },

        copyText() {
            const text = document.getElementById('captionResult')?.value;
            if(text) {
                navigator.clipboard.writeText(text).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                });
            }
        }
    }
}
</script>
@endsection
