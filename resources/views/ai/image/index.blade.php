@extends('layouts.app')

@section('title', 'AI Image Studio')

@section('content')
<!-- Kontainer Utama dengan Dukungan Tema Terang & Gelap -->
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white py-6 px-4 md:px-8 transition-colors duration-300" x-data="imageGenerator({{ auth()->user()->credits }})">

    <!-- Header Atas & Kredit -->
    <div class="max-w-7xl mx-auto mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight flex items-center gap-2">
                <span class="bg-gradient-to-r from-purple-500 to-sky-500 dark:from-purple-400 dark:to-sky-400 bg-clip-text text-transparent">AI Image Studio</span>
                <span class="text-[10px] bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-300 px-2 py-0.5 rounded-full border border-purple-200 dark:border-purple-500/30">PRO</span>
            </h1>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Ubah idemu menjadi visual yang menakjubkan</p>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 px-5 py-3 rounded-xl flex items-center gap-3 shadow-sm dark:shadow-lg transition-colors">
            <div class="text-sky-500 dark:text-sky-400 text-xl">💎</div>
            <div>
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400">Saldo</p>
                <p class="font-extrabold text-lg text-gray-900 dark:text-white leading-tight">{{ auth()->user()->credits }} <span class="text-xs font-medium text-gray-400 dark:text-slate-500">Kredit</span></p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- PANEL KIRI: Kontrol -->
        <div class="lg:col-span-2 space-y-4">

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-300 p-4 rounded-xl flex items-start gap-3">
                    <span class="text-red-500 dark:text-red-400 text-lg mt-0.5">⚠️</span>
                    <div>
                        <p class="font-semibold text-sm">Gagal Menghasilkan</p>
                        <p class="text-xs mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('ai.image.generate') }}" method="POST" id="imageForm" @submit.prevent="handleGenerate">
                @csrf

                <!-- Input Prompt -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm dark:shadow-md transition-colors">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-semibold text-gray-800 dark:text-slate-200 flex items-center gap-1.5">✨ Prompt</label>
                        <button type="button" @click="surpriseMe" class="text-[10px] bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-sky-600 dark:text-sky-300 px-2 py-1 rounded-md transition flex items-center gap-1">
                            🎲 <span>Kejutkan Saya</span>
                        </button>
                    </div>
                    <textarea name="description" x-model="prompt" rows="4" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Interior kedai kopi yang nyaman dengan hujan di luar jendela, pencahayaan sinematik, resolusi 8k..." required></textarea>

                    <!-- Toggle Prompt Negatif -->
                    <div class="mt-3">
                        <button type="button" @click="showNegPrompt = !showNegPrompt" class="text-xs text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white transition flex items-center gap-1">
                            <svg class="w-3 h-3 transition" :class="showNegPrompt ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Prompt Negatif (Opsional)
                        </button>
                        <div x-show="showNegPrompt" x-transition class="mt-2">
                            <input type="text" name="negative_prompt" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition placeholder:text-gray-400 dark:placeholder:text-slate-500" placeholder="Hal yang perlu dihindari: buram, teks, cacat, jelek...">
                        </div>
                    </div>
                </div>

                <!-- Gaya & Pengaturan -->
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm dark:shadow-md space-y-5 transition-colors">

                    <!-- Gaya Seni -->
                    <div>
                        <label class="text-sm font-semibold text-gray-800 dark:text-slate-200 mb-3 block">🎨 Gaya Seni</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" @click="style = 'realistic'" :class="style === 'realistic' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">📷 Realistis</button>
                            <button type="button" @click="style = 'anime'" :class="style === 'anime' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">⛩️ Anime</button>
                            <button type="button" @click="style = '3d'" :class="style === '3d' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">🎮 3D Render</button>
                            <button type="button" @click="style = 'cyberpunk'" :class="style === 'cyberpunk' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">🌃 Cyberpunk</button>
                            <button type="button" @click="style = 'watercolor'" :class="style === 'watercolor' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">🎨 Cat Air</button>
                            <button type="button" @click="style = 'cinematic'" :class="style === 'cinematic' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:border-gray-300 dark:hover:border-slate-400'" class="border rounded-lg p-2 text-xs font-medium transition text-center">🎬 Sinematik</button>
                        </div>
                        <input type="hidden" name="style" x-model="style">
                    </div>

                    <!-- Rasio Aspek -->
                    <div>
                        <label class="text-sm font-semibold text-gray-800 dark:text-slate-200 mb-3 block">📐 Rasio Aspek</label>
                        <div class="flex gap-2">
                            <button type="button" @click="ratio = '1:1'" :class="ratio === '1:1' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400'" class="flex-1 border rounded-lg p-2 flex flex-col items-center justify-center gap-1 transition">
                                <div class="w-5 h-5 border-2 rounded-sm" :class="ratio === '1:1' ? 'border-sky-500 dark:border-sky-300' : 'border-gray-300 dark:border-slate-500'"></div>
                                <span class="text-[10px] font-medium">1:1</span>
                            </button>
                            <button type="button" @click="ratio = '16:9'" :class="ratio === '16:9' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400'" class="flex-1 border rounded-lg p-2 flex flex-col items-center justify-center gap-1 transition">
                                <div class="w-6 h-3.5 border-2 rounded-sm" :class="ratio === '16:9' ? 'border-sky-500 dark:border-sky-300' : 'border-gray-300 dark:border-slate-500'"></div>
                                <span class="text-[10px] font-medium">16:9</span>
                            </button>
                            <button type="button" @click="ratio = '9:16'" :class="ratio === '9:16' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400'" class="flex-1 border rounded-lg p-2 flex flex-col items-center justify-center gap-1 transition">
                                <div class="w-3.5 h-6 border-2 rounded-sm" :class="ratio === '9:16' ? 'border-sky-500 dark:border-sky-300' : 'border-gray-300 dark:border-slate-500'"></div>
                                <span class="text-[10px] font-medium">9:16</span>
                            </button>
                            <button type="button" @click="ratio = '4:3'" :class="ratio === '4:3' ? 'bg-sky-50 dark:bg-sky-500/20 border-sky-500 text-sky-600 dark:text-sky-300' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400'" class="flex-1 border rounded-lg p-2 flex flex-col items-center justify-center gap-1 transition">
                                <div class="w-5 h-4 border-2 rounded-sm" :class="ratio === '4:3' ? 'border-sky-500 dark:border-sky-300' : 'border-gray-300 dark:border-slate-500'"></div>
                                <span class="text-[10px] font-medium">4:3</span>
                            </button>
                        </div>
                        <input type="hidden" name="ratio" x-model="ratio">
                    </div>

                </div>

                <!-- Tombol Generate -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-sky-600 hover:from-purple-500 hover:to-sky-500 py-4 rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-purple-500/20 text-white disabled:opacity-40 disabled:cursor-not-allowed relative overflow-hidden"
                    :disabled="isGenerating || credits < 5">

                    <div x-show="!isGenerating" class="flex items-center gap-2">
                        <span>Buat Gambar</span>
                        <span class="bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-semibold">-5 💎</span>
                    </div>

                    <div x-show="isGenerating" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Sedang Membuat...</span>
                    </div>
                </button>

                @if(auth()->user()->credits < 5)
                    <p class="text-red-500 dark:text-red-400 text-xs text-center mt-2 animate-pulse">Kredit tidak cukup untuk membuat gambar</p>
                @endif

            </form>
        </div>

        <!-- PANEL KANAN: Pratinjau Hasil -->
        <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm dark:shadow-md overflow-hidden flex flex-col relative min-h-[400px] lg:min-h-[600px] transition-colors">

            <!-- Hasil Gambar / Placeholder -->
            <div class="flex-1 flex items-center justify-center p-6 relative">

                <!-- Kondisi Kosong -->
                <div x-show="!isGenerating && !hasResult" class="text-center p-8 max-w-md">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-4xl">🖼️</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200 mb-2">Kanvasmu Menunggu</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mb-6">Tulis prompt, pilih gaya, dan biarkan AI melakukan keajaibannya.</p>
                    <div class="bg-gray-50 dark:bg-slate-900 p-3 rounded-lg border border-gray-200 dark:border-slate-600 text-left text-xs text-gray-600 dark:text-slate-300">
                        <p class="text-sky-500 dark:text-sky-400 mb-1 font-semibold">💡 Coba ini:</p>
                        <p class="italic cursor-pointer hover:text-gray-900 dark:hover:text-white transition" x-on:click="prompt = 'Seorang samurai futuristik berdiri di jalanan hujan yang diterangi neon, gaya cyberpunk, sangat detail, 8k'">"Seorang samurai futuristik berdiri di jalanan hujan yang diterangi neon, gaya cyberpunk, sangat detail, 8k"</p>
                    </div>
                </div>

                <!-- Kondisi Loading -->
                <div x-show="isGenerating" class="text-center p-8 absolute inset-0 bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm flex flex-col items-center justify-center z-10 transition-colors">
                    <div class="relative w-24 h-24 mb-6">
                        <div class="absolute inset-0 border-4 border-purple-200 dark:border-purple-500/30 rounded-full"></div>
                        <div class="absolute inset-0 border-4 border-transparent border-t-sky-500 dark:border-t-sky-400 rounded-full animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-3xl">✨</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Membuat gambar Anda...</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm">Ini biasanya memakan waktu 10-15 detik</p>
                </div>

                <!-- Kondisi Hasil -->
                @if(isset($content))
                    <div class="w-full h-full flex flex-col items-center justify-center" x-init="hasResult = true">
                        <img src="{{ $content->result }}" class="max-w-full max-h-[450px] rounded-lg shadow-2xl shadow-black/10 dark:shadow-black/50 object-contain border border-gray-200 dark:border-slate-600" alt="Hasil AI">

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex flex-wrap gap-3 justify-center">
                            <a href="{{ $content->result }}" download="larislo-ai-image.png" class="bg-sky-600 hover:bg-sky-500 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-md text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh
                            </a>
                            <button @click="copyPrompt" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span x-text="copied ? 'Tersalin!' : 'Salin Prompt'"></span>
                            </button>
                            <button class="bg-purple-600 hover:bg-purple-500 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-md text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                Perbesar (10 💎)
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

<script>
function imageGenerator(initialCredits) {
    return {
        credits: initialCredits,
        prompt: '',
        style: 'realistic',
        ratio: '1:1',
        showNegPrompt: false,
        isGenerating: false,
        hasResult: false,
        copied: false,

        handleGenerate() {
            if(this.credits < 5) return;
            this.isGenerating = true;
            this.hasResult = false;
            // Kirim form secara normal
            document.getElementById('imageForm').submit();
        },

        surpriseMe() {
            const prompts = [
                'Perpustakaan rumah pohon ajaib dengan lampu peri bercahaya dan buku kuno, seni fantasi, detail',
                'Astronot bermeditasi di permukaan mars, bumi di langit, pencahayaan sinematik, 8k',
                'Corgi lucu berpakaian seperti koki sushi, bekerja di restoran Jepang, gaya anime',
                'Stasiun luar angkasa terbengkalai ditumbuhi tanaman bioluminesensi, seni konsep sci-fi',
                'Kapal hantu berlayar di lautan awan di bawah bulan sabit, lukisan cat air'
            ];
            this.prompt = prompts[Math.floor(Math.random() * prompts.length)];
        },

        copyPrompt() {
            navigator.clipboard.writeText(this.prompt).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }
}
</script>
@endsection
