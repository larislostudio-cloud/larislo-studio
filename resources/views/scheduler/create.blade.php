@extends('layouts.app')

@section('title', 'Create Scheduled Post')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white py-6 px-4 md:px-8 transition-colors duration-300" x-data="postCreator()">

    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Schedule New Post</h1>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Buat jadwal posting untuk semua platform sekaligus.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <form action="{{ route('social.scheduler.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Platform -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 mb-4 flex items-center gap-2">1. Target Platforms</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" @click="togglePlatform('instagram')" :class="selectedPlatforms.includes('instagram') ? 'border-pink-500 bg-pink-50 dark:bg-pink-500/10 shadow-sm' : 'border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500'" class="border rounded-xl p-4 transition flex flex-col items-center gap-2">
                            <span class="text-2xl">📸</span>
                            <span class="text-xs font-bold" :class="selectedPlatforms.includes('instagram') ? 'text-pink-600 dark:text-pink-300' : 'text-gray-500 dark:text-slate-400'">Instagram</span>
                        </button>
                        <button type="button" @click="togglePlatform('facebook')" :class="selectedPlatforms.includes('facebook') ? 'border-blue-500 bg-blue-50 dark:bg-blue-500/10 shadow-sm' : 'border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500'" class="border rounded-xl p-4 transition flex flex-col items-center gap-2">
                            <span class="text-2xl">📘</span>
                            <span class="text-xs font-bold" :class="selectedPlatforms.includes('facebook') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-slate-400'">Facebook</span>
                        </button>
                        <button type="button" @click="togglePlatform('tiktok')" :class="selectedPlatforms.includes('tiktok') ? 'border-gray-800 dark:border-white bg-gray-50 dark:bg-white/10 shadow-sm' : 'border-gray-200 dark:border-slate-600 hover:border-gray-300 dark:hover:border-slate-500'" class="border rounded-xl p-4 transition flex flex-col items-center gap-2">
                            <span class="text-2xl">🎵</span>
                            <span class="text-xs font-bold" :class="selectedPlatforms.includes('tiktok') ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-slate-400'">TikTok</span>
                        </button>
                    </div>
                    <!-- Hidden inputs for form submission -->
                    <template x-for="platform in selectedPlatforms" :key="platform">
                        <input type="hidden" name="platforms[]" :value="platform">
                    </template>
                    @error('platforms') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Step 2: Media -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 mb-4 flex items-center gap-2">2. Media</h3>
                    <label class="w-full py-8 border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-xl hover:border-sky-500 dark:hover:border-sky-400 bg-gray-50 dark:bg-slate-900 transition flex flex-col items-center justify-center cursor-pointer group relative" :class="mediaPreview ? 'border-sky-500 dark:border-sky-400' : ''">
                        <div x-show="!mediaPreview" class="text-center">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-400 dark:text-slate-500 group-hover:text-sky-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400 group-hover:text-sky-500 dark:group-hover:text-sky-400 transition">Upload Image or Video</p>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">JPG, PNG, MP4. Max 10MB</p>
                        </div>
                        <div x-show="mediaPreview" class="absolute inset-0 p-2 flex items-center justify-center">
                            <img :src="mediaPreview" class="max-h-full max-w-full object-contain rounded-lg">
                        </div>
                        <input type="file" name="media" accept="image/*,video/*" class="hidden" @change="previewMedia($event)">
                    </label>
                </div>

                <!-- Step 3: Caption -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200">3. Caption</h3>
                        <button type="button" @click="enhanceCaption" class="text-[10px] bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300 px-2 py-1 rounded-md font-bold transition hover:bg-purple-200 dark:hover:bg-purple-500/30 flex items-center gap-1">
                            ✨ Enhance with AI
                        </button>
                    </div>
                    <div class="relative">
                        <textarea name="content" x-model="caption" rows="5" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500 resize-none" placeholder="Tulis caption yang menarik..."></textarea>
                        <span class="absolute bottom-2 right-3 text-[10px] font-mono" :class="caption.length > 2200 ? 'text-red-500' : 'text-gray-400 dark:text-slate-500'" x-text="caption.length + '/2200'"></span>
                    </div>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Step 4: Schedule & Options -->
                <div class="p-6">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 mb-4">4. Schedule</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1">Date & Time</label>
                            <input type="datetime-local" name="publish_at" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-lg p-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('publish_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-end">
                            <label class="w-full bg-gray-50 dark:bg-slate-900 p-3 rounded-lg border border-gray-200 dark:border-slate-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-800 transition flex items-center gap-3">
                                <input type="checkbox" name="ai_schedule" value="1" class="w-4 h-4 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 dark:focus:ring-sky-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600" {{ auth()->user()->credits < 2 ? 'disabled' : '' }}>
                                <div>
                                    <span class="font-bold text-xs text-gray-800 dark:text-slate-200">⚡ Smart Schedule</span>
                                    <p class="text-[10px] text-gray-500 dark:text-slate-400">AI finds best time (-2 💎)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-3.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-bold rounded-xl shadow-lg shadow-sky-500/20 transition flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Schedule Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function postCreator() {
    return {
        selectedPlatforms: [],
        caption: '',
        mediaPreview: null,

        togglePlatform(platform) {
            const index = this.selectedPlatforms.indexOf(platform);
            if (index > -1) {
                this.selectedPlatforms.splice(index, 1);
            } else {
                this.selectedPlatforms.push(platform);
            }
        },

        previewMedia(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.mediaPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.mediaPreview = null;
            }
        },

        enhanceCaption() {
            if(this.caption.trim() === '') this.caption = "Produk terbaru kami punya sesuatu yang spesial! ";
            const keywords = "\n\n🔥 Promo Spesial! Dapatkan diskon spesial untuk pembelian pertama. Gunakan kode PROMO pertama! Link di bio. #Promo #Diskon #FYP";
            if(!this.caption.includes(keywords)) this.caption += keywords;
        }
    }
}
</script>
@endsection
