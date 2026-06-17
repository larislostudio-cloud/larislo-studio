@extends('layouts.app')

@section('title', 'AI Video Studio')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div x-data="videoEditor(@json($project))" @keydown.ctrl.z.prevent="undo()" @keydown.ctrl.y.prevent="redo()" @keydown.ctrl.s.prevent="autosave()" @keydown.delete.prevent="deleteSelectedClip()" @keydown.s.prevent="splitClip()" @keydown.escape="closeAllPanels()" class="h-[calc(100vh-64px)] flex flex-col bg-gray-100 dark:bg-slate-950 text-gray-900 dark:text-white overflow-hidden select-none transition-colors duration-300">

    <!-- ===================== TOP BAR ===================== -->
    <header class="h-12 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-200 dark:border-slate-700/50 flex items-center justify-between px-3 shrink-0 z-40 transition-colors">
        <div class="flex items-center gap-3 min-w-0">
            <button @click="togglePanel('left')" :class="leftPanelOpen ? 'text-sky-500 dark:text-sky-400 bg-sky-100 dark:bg-sky-500/20 shadow-[0_0_10px_rgba(14,165,233,0.2)]' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-700/50'" class="p-1.5 rounded-lg transition-all duration-200" title="Tools Panel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-[11px] sm:text-sm font-black tracking-widest bg-gradient-to-r from-sky-600 to-blue-700 dark:from-sky-400 dark:to-blue-500 bg-clip-text text-transparent shrink-0">LARISLO STUDIO</h1>
            <input type="text" x-model="projectName" class="bg-gray-100 dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-md px-2 py-1 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500/50 w-28 sm:w-48 transition-all" />
            <div class="hidden sm:flex items-center gap-1 ml-1 bg-gray-100 dark:bg-slate-800/50 rounded-lg p-1 border border-gray-200 dark:border-slate-700/50">
                <button @click="undo()" class="p-1 text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white disabled:opacity-30 rounded transition" :disabled="historyIndex <= 0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2M3 10l4-4m-4 4l4 4"></path></svg></button>
                <button @click="redo()" class="p-1 text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white disabled:opacity-30 rounded transition" :disabled="historyIndex >= history.length - 1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m15-7l-4-4m4 4l-4 4"></path></svg></button>
                <div class="w-px h-4 bg-gray-200 dark:bg-slate-700 mx-1"></div>
                <button @click="splitClip()" class="p-1 text-gray-500 dark:text-slate-400 hover:text-sky-500 dark:hover:text-sky-400 rounded transition" title="Split (S)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-7 7m7-7l-7-7"></path></svg></button>
            </div>
        </div>
        <div class="flex items-center gap-2 sm:gap-3">
            <button @click="toggleVoiceRecord()" :class="isRecordingVoice ? 'text-red-500 dark:text-red-400 bg-red-100 dark:bg-red-500/20 animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.3)]' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white'" class="p-1.5 rounded-lg transition-all" title="Voice">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
            </button>
            <div class="flex items-center gap-1.5 bg-gray-100 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 rounded-lg px-2.5 py-1.5">
                <span class="text-sky-500 dark:text-sky-400 text-xs">💎</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white">{{ auth()->user()->credits }}</span>
            </div>
            <button @click="autosave()" :disabled="isSaving" class="p-1.5 text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white disabled:opacity-50 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-700/50 transition" title="Save">
                <svg x-show="!isSaving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                <svg x-show="isSaving" class="w-4 h-4 animate-spin text-sky-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </button>
            <button @click="showExportModal = true" class="px-3 py-1.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-400 hover:to-rose-500 rounded-lg text-[11px] sm:text-xs font-bold transition-all shadow-lg shadow-red-500/20 flex items-center gap-1.5 text-white">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span class="hidden sm:inline">Export</span>
            </button>
            <button @click="togglePanel('right')" :class="rightPanelOpen ? 'text-sky-500 dark:text-sky-400 bg-sky-100 dark:bg-sky-500/20 shadow-[0_0_10px_rgba(14,165,233,0.2)]' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-slate-700/50'" class="p-1.5 rounded-lg transition-all duration-200" title="Inspector Panel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </button>
        </div>
    </header>

    <!-- ===================== MAIN CONTENT WRAPPER (ROW FLEX) ===================== -->
    <div class="flex-1 flex min-h-0 overflow-hidden">

        <!-- ===================== LEFT PANEL INLINE (Tools) ===================== -->
        <div class="shrink-0 overflow-hidden transition-all duration-300 ease-in-out bg-white dark:bg-slate-900 border-r border-gray-200 dark:border-slate-700/50 flex flex-col" :class="leftPanelOpen ? 'w-80 sm:w-96' : 'w-0 border-r-0'">
            <!-- Fixed width inner container to prevent content squishing -->
            <div class="w-80 sm:w-96 h-full flex flex-col">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-slate-700/50 shrink-0">
                    <h2 class="text-sm font-bold text-gray-800 dark:text-slate-200 flex items-center gap-2"><span class="text-sky-500">🧰</span> Tools</h2>
                    <button @click="leftPanelOpen = false" class="p-1 text-gray-400 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="flex border-b border-gray-200 dark:border-slate-700/50 shrink-0 bg-gray-50 dark:bg-slate-900/50">
                    <button @click="leftTab = 'ai'" :class="leftTab === 'ai' ? 'bg-white dark:bg-slate-800/50 border-b-2 border-sky-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-3 text-[11px] font-semibold text-center transition-all">✨ AI</button>
                    <button @click="leftTab = 'media'" :class="leftTab === 'media' ? 'bg-white dark:bg-slate-800/50 border-b-2 border-sky-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-3 text-[11px] font-semibold text-center transition-all">Media</button>
                    <button @click="leftTab = 'text'" :class="leftTab === 'text' ? 'bg-white dark:bg-slate-800/50 border-b-2 border-sky-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-3 text-[11px] font-semibold text-center transition-all">Text</button>
                    <button @click="leftTab = 'audio'" :class="leftTab === 'audio' ? 'bg-white dark:bg-slate-800/50 border-b-2 border-sky-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-3 text-[11px] font-semibold text-center transition-all">Audio</button>
                </div>
                <div class="flex-1 p-4 overflow-y-auto space-y-4">
                    <!-- AI Tab -->
                    <template x-if="leftTab === 'ai'">
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-semibold text-gray-700 dark:text-slate-300">Prompt (5 💎)</label>
                                    <button type="button" @click="enhancePrompt()" class="text-[10px] bg-sky-100 dark:bg-sky-500/20 hover:bg-sky-200 dark:hover:bg-sky-500/30 text-sky-600 dark:text-sky-300 px-2 py-1 rounded-md transition flex items-center gap-1 font-bold">✨ Enhance</button>
                                </div>
                                <textarea x-model="aiPrompt" rows="5" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg p-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition placeholder:text-gray-400 dark:placeholder:text-slate-500 resize-none" placeholder="e.g., Create a 10s promo video..."></textarea>
                            </div>
                            <button @click="generateAiVideo()" class="w-full bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-500 hover:to-blue-500 p-4 rounded-xl text-left transition-all flex items-center gap-3 shadow-lg shadow-sky-500/20 hover:shadow-sky-500/30 text-white">
                                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div><p class="text-sm font-bold">Generate Video</p><p class="text-xs text-sky-200 mt-0.5">AI will build timeline</p></div>
                            </button>
                        </div>
                    </template>
                    <!-- Media Tab -->
                    <template x-if="leftTab === 'media'">
                        <div>
                            <label class="w-full py-10 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-xl hover:border-sky-500 bg-gray-50 dark:bg-slate-800/20 hover:bg-sky-50 dark:hover:bg-sky-500/5 text-gray-500 dark:text-slate-400 hover:text-sky-600 dark:hover:text-sky-400 transition-all flex flex-col items-center justify-center cursor-pointer group">
                                <svg class="w-10 h-10 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-sm font-medium">Upload Video / Image</span>
                                <input type="file" accept="video/*,image/*" @change="handleFileUpload($event)" class="hidden">
                            </label>
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <template x-for="file in uploadedFiles" :key="file.id">
                                    <div class="bg-white dark:bg-slate-800/50 aspect-video rounded-lg cursor-pointer hover:ring-2 ring-sky-500 transition flex items-center justify-center text-[10px] text-gray-500 dark:text-slate-400 p-1 truncate relative group border border-gray-200 dark:border-slate-700/50" @click="addUploadedMediaToTimeline(file)">
                                        <span x-text="file.name" class="pointer-events-none"></span>
                                        <div class="absolute inset-0 bg-black/40 dark:bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center pointer-events-none"><span class="text-white text-lg">+</span></div>
                                        <button @click.stop="removeUploadedFile(file.id)" class="absolute top-1 right-1 text-gray-400 dark:text-white/40 hover:text-red-500 dark:hover:text-red-400 z-10 bg-white/80 dark:bg-slate-900/80 rounded-full p-0.5 border border-gray-200 dark:border-slate-700"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <!-- Text Tab -->
                    <template x-if="leftTab === 'text'">
                        <div class="space-y-3">
                            <p class="text-[10px] font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Quick Presets</p>
                            <button @click="addTextClip('Title', 64, '#000000', 'sans-serif')" class="w-full bg-white dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 p-3 rounded-lg text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">Title Text</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">64px Sans Serif</p>
                            </button>
                            <button @click="addTextClip('Subtitle', 36, '#4b5563', 'sans-serif')" class="w-full bg-white dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 p-3 rounded-lg text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <p class="text-xl font-semibold text-gray-600 dark:text-slate-300">Subtitle Text</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">36px Sans Serif</p>
                            </button>
                            <button @click="addTextClip('Caption', 18, '#6b7280', 'sans-serif')" class="w-full bg-white dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 p-3 rounded-lg text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                <p class="text-sm text-gray-500 dark:text-slate-300">Caption Text</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">18px Sans Serif</p>
                            </button>
                        </div>
                    </template>
                    <!-- Audio Tab -->
                    <template x-if="leftTab === 'audio'">
                        <div class="space-y-4">
                            <label class="w-full py-6 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-xl hover:border-sky-500 bg-gray-50 dark:bg-slate-800/20 hover:bg-sky-50 dark:hover:bg-sky-500/5 text-gray-500 dark:text-slate-400 hover:text-sky-600 dark:hover:text-sky-400 transition-all flex flex-col items-center justify-center cursor-pointer">
                                <span class="text-sm font-medium">Upload Local Audio</span>
                                <input type="file" accept="audio/*" @change="handleAudioUpload($event)" class="hidden">
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></div>
                                <input type="text" x-model="audioUrl" placeholder="Paste audio URL..." class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg pl-9 pr-3 py-2.5 text-xs text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition">
                            </div>
                            <button @click="addAudioFromUrl()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 p-2.5 rounded-lg text-xs font-bold hover:bg-gray-50 dark:hover:bg-slate-700/50 transition text-center">Import from URL</button>
                            <div class="border-t border-gray-200 dark:border-slate-700/50 pt-4">
                                <button @click="addAudioClip('bgm')" class="w-full bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800/50 p-3 rounded-lg text-left hover:border-green-400 dark:hover:border-green-500/50 transition flex items-center gap-3">
                                    <span class="text-2xl">🎵</span>
                                    <div><p class="text-sm font-bold text-green-800 dark:text-green-200">Stock Background Music</p><p class="text-[10px] text-green-500 dark:text-green-400/50 mt-0.5">Royalty Free</p></div>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ===================== CENTER WORKSPACE ===================== -->
        <div class="flex-1 flex flex-col min-h-0 min-w-0 overflow-hidden">
            <!-- PREVIEW AREA -->
            <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
                <div class="flex-1 flex items-center justify-center p-2 sm:p-4 md:p-6 bg-gray-200 dark:bg-[#0A0A0A] min-h-0 overflow-hidden relative transition-colors">
                    <div id="preview-canvas" class="relative w-full max-w-3xl aspect-video bg-black rounded-xl shadow-2xl shadow-gray-400/20 dark:shadow-black/80 border border-gray-300 dark:border-slate-800/50 overflow-hidden cursor-pointer z-10 transition-colors" @click="isPlaying = !isPlaying">
                        <template x-for="track in tracks" :key="track.id">
                            <template x-for="clip in track.clips" :key="clip.id">
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden"
                                     x-show="currentTime >= clip.start && currentTime <= clip.start + clip.duration"
                                     :style="`opacity: ${clip.opacity || 1}; transition: ${clip.transition ? clip.transitionDuration + 's' : '0s'}; transform: scale(${clip.zoom || 1}) rotateY(${clip.mirror ? 180 : 0}deg); filter: ${clip.filter || 'none'}`">
                                    <div x-show="clip.type === 'video' || clip.type === 'image'" class="w-full h-full bg-slate-800 flex items-center justify-center">
                                        <video x-show="clip.type === 'video' && clip.src" :src="clip.src" :data-clip-id="clip.id" class="w-full h-full object-cover" playsinline :muted="isMuted"></video>
                                        <img x-show="clip.type === 'image' && clip.src" :src="clip.src" class="w-full h-full object-cover">
                                        <span x-show="!clip.src" class="text-gray-500 dark:text-slate-600 text-xs sm:text-sm" x-text="clip.name"></span>
                                    </div>
                                    <div x-show="clip.type === 'text'" class="absolute flex flex-col items-center justify-center w-full h-full p-4 sm:p-8" :style="`transform: translate(${clip.x || 0}%, ${clip.y || 0}%)`">
                                        <span class="font-bold text-center drop-shadow-lg whitespace-pre-wrap" :style="`font-size: ${clip.fontSize}px; color: ${clip.fontColor || '#ffffff'}; font-family: ${clip.fontFamily || 'sans-serif'}`" x-text="clip.content"></span>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <div x-show="!isPlaying" x-transition class="absolute inset-0 flex items-center justify-center bg-black/30 pointer-events-none z-10">
                            <div class="w-14 h-14 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center shadow-xl border border-white/20 hover:bg-white/20 transition">
                                <svg class="w-7 h-7 sm:w-10 sm:h-10 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-2 sm:p-3 pt-8 sm:pt-10 z-20" @click.stop>
                            <div class="w-full h-1 sm:h-1.5 bg-white/20 rounded-full cursor-pointer mb-2" @click.stop="seekPreview($event)">
                                <div class="h-full bg-gradient-to-r from-sky-500 to-blue-500 rounded-full relative" :style="`width: ${duration > 0 ? (currentTime / duration) * 100 : 0}%`">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full shadow-lg scale-0 hover:scale-125 transition"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <button @click.stop="isPlaying = !isPlaying" class="text-white hover:text-sky-400 transition">
                                        <svg x-show="!isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                        <svg x-show="isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                                    </button>
                                    <span class="text-[10px] sm:text-[11px] font-mono text-white/80 bg-black/40 px-1.5 py-0.5 rounded" x-text="formatTime(currentTime) + ' / ' + formatTime(duration)"></span>
                                </div>
                                <div class="flex items-center gap-2" @click.stop>
                                    <button @click.stop="toggleFullscreen()" class="text-white/80 hover:text-white transition hidden sm:block" title="Fullscreen"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg></button>
                                    <button @click.stop="isMuted = !isMuted" class="text-white/80 hover:text-white transition">
                                        <svg x-show="!isMuted && masterVolume > 0" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        <svg x-show="isMuted || masterVolume == 0" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path></svg>
                                    </button>
                                    <input type="range" x-model.number="masterVolume" min="0" max="1" step="0.05" class="w-16 sm:w-24 h-1 accent-sky-500 cursor-pointer" @click.stop @mousedown.stop @input.stop>
                                </div>
                            </div>
                        </div>
                        <div x-show="getActiveClips().length === 0 && !isPlaying" class="absolute inset-0 flex items-center justify-center text-center pointer-events-none z-0">
                            <div class="space-y-2">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <p class="text-gray-500 dark:text-slate-600 text-xs sm:text-sm font-medium">Add media to timeline</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Playback Bar -->
                <div class="h-10 sm:h-12 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-t border-gray-200 dark:border-slate-700/50 flex items-center justify-center gap-2 sm:gap-3 shrink-0 px-2 sm:px-4 z-10 transition-colors">
                    <span class="text-[10px] sm:text-xs font-mono text-gray-500 dark:text-slate-400 w-12 sm:w-16 text-right" x-text="formatTime(currentTime)"></span>
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <button @click="currentTime = 0" class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white transition"><svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"></path></svg></button>
                        <button @click="isPlaying = !isPlaying" class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-full flex items-center justify-center hover:from-sky-400 hover:to-blue-500 transition shadow-lg shadow-sky-500/30 text-white">
                            <svg x-show="!isPlaying" class="w-4 h-4 sm:w-5 sm:h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                            <svg x-show="isPlaying" class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                        </button>
                        <button @click="currentTime = duration" class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white transition"><svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"></path></svg></button>
                    </div>
                    <div class="flex items-center gap-1">
                        <button @click="isMuted = !isMuted" class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white transition">
                            <svg x-show="!isMuted && masterVolume > 0" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                            <svg x-show="isMuted || masterVolume == 0" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path></svg>
                        </button>
                        <input type="range" x-model.number="masterVolume" min="0" max="1" step="0.05" class="w-12 sm:w-20 h-1 accent-sky-500 cursor-pointer">
                        <span class="text-[9px] sm:text-[10px] text-gray-400 dark:text-slate-500 w-6 sm:w-8 font-mono" x-text="Math.round(masterVolume * 100) + '%'"></span>
                    </div>
                    <span class="text-[10px] sm:text-xs font-mono text-gray-500 dark:text-slate-400 w-12 sm:w-16" x-text="formatTime(duration)"></span>
                </div>
            </div>

            <!-- Resize Handle -->
            <div @mousedown="startResizeTimeline($event)" class="h-2 bg-gray-100 dark:bg-slate-900 border-y border-gray-200 dark:border-slate-700/50 cursor-ns-resize hover:bg-sky-200 dark:hover:bg-sky-600/50 transition-colors duration-150 flex items-center justify-center shrink-0 group/resize">
                <div class="w-10 h-1 rounded-full bg-gray-300 dark:bg-slate-700 group-hover/resize:bg-sky-500 dark:group-hover/resize:bg-sky-400 transition"></div>
            </div>

            <!-- TIMELINE -->
            <div class="flex flex-col overflow-hidden shrink-0 bg-gray-200 dark:bg-slate-950 transition-colors" :style="`height: ${timelineHeight}px`">
                <div class="h-8 sm:h-9 bg-white/50 dark:bg-slate-900/50 flex items-center justify-between px-2 sm:px-4 border-b border-gray-200 dark:border-slate-700/50 shrink-0">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button @click="addTrack('video')" class="text-[10px] sm:text-[11px] bg-white dark:bg-slate-800/50 hover:bg-gray-50 dark:hover:bg-slate-700 border border-gray-200 dark:border-slate-700/50 px-2 py-1 rounded-md transition font-medium text-gray-700 dark:text-sky-300">+ Video</button>
                        <button @click="addTrack('audio')" class="text-[10px] sm:text-[11px] bg-white dark:bg-slate-800/50 hover:bg-gray-50 dark:hover:bg-slate-700 border border-gray-200 dark:border-slate-700/50 px-2 py-1 rounded-md transition font-medium text-gray-700 dark:text-sky-300">+ Audio</button>
                        <button @click="splitClip()" class="text-[10px] sm:text-[11px] bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 dark:hover:bg-sky-500/20 border border-sky-300 dark:border-sky-500/50 text-sky-700 dark:text-sky-300 px-2 py-1 rounded-md transition font-bold">✂ Split</button>
                    </div>
                    <div class="flex items-center gap-1 sm:gap-2 bg-white dark:bg-slate-800/50 rounded-md p-0.5 border border-gray-200 dark:border-slate-700/50">
                        <button @click="zoom = Math.max(0.2, zoom - 0.2)" class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white text-xs px-1.5 transition">−</button>
                        <span class="text-[10px] sm:text-[11px] text-sky-600 dark:text-sky-400 font-mono font-bold w-8 sm:w-10 text-center" x-text="Math.round(zoom * 100) + '%'"></span>
                        <button @click="zoom = Math.min(3, zoom + 0.2)" class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white text-xs px-1.5 transition">+</button>
                    </div>
                </div>
                <div class="flex-1 flex overflow-auto min-h-0">
                    <div class="w-16 sm:w-28 shrink-0 bg-white dark:bg-slate-900/80 border-r border-gray-200 dark:border-slate-700/50 sticky left-0 z-10">
                        <div class="h-6 sm:h-7 border-b border-gray-200 dark:border-slate-700/50 shrink-0"></div>
                        <template x-for="track in tracks" :key="track.id">
                            <div class="h-14 sm:h-[70px] border-b border-gray-100 dark:border-slate-800/50 flex items-center justify-center px-0.5 sm:px-1 relative group/track bg-gray-50 dark:bg-slate-950/50">
                                <span class="text-[8px] sm:text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-slate-400 truncate" x-text="track.type === 'video' ? '🎬 Video' : '🔊 Audio'"></span>
                                <button @click="removeTrack(track.id)" class="absolute top-0 right-0 text-red-500 opacity-0 group-hover/track:opacity-100 hover:text-red-400 text-[8px] sm:text-[10px] bg-red-100 dark:bg-red-500/20 rounded-bl px-1 transition">✕</button>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 relative min-w-0 bg-gray-100 dark:bg-black" @click.self="selectedClip = null" @mousedown.self="seekTo($event)">
                        <div class="h-6 sm:h-7 border-b border-gray-200 dark:border-slate-700/50 relative bg-white dark:bg-slate-900/80 cursor-pointer sticky top-0 z-10" @mousedown="seekTo($event)">
                            <template x-for="i in Math.ceil(duration + 10)">
                                <div class="absolute top-0 h-full border-l border-gray-200 dark:border-slate-800 text-[8px] sm:text-[10px] text-gray-400 dark:text-slate-500 pl-0.5 sm:pl-1 pt-0.5 sm:pt-1" :style="`left: ${(i-1) * 100 * zoom}px`" x-text="i + 's'"></div>
                            </template>
                        </div>
                        <div class="absolute top-0 bottom-0 w-0.5 bg-red-500 z-20 pointer-events-none shadow-[0_0_8px_rgba(239,68,68,0.5)]" :style="`left: ${currentTime * 100 * zoom}px`">
                            <div class="absolute -top-0 left-1/2 -translate-x-1/2 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-red-500 rotate-45 rounded-sm border border-red-400"></div>
                        </div>
                        <template x-for="track in tracks" :key="track.id">
                            <div class="h-14 sm:h-[70px] border-b border-gray-100 dark:border-slate-800/30 relative transition-colors" :class="dragOverTrackId === track.id ? 'bg-sky-100/50 dark:bg-sky-900/20' : ''" @dragover.prevent="dragOverTrackId = track.id" @dragleave="dragOverTrackId = null" @drop.prevent="onDropToTrack(track, $event)">
                                <template x-for="clip in track.clips" :key="clip.id">
                                    <div @click.stop="selectClip(clip)" @mousedown.prevent="startClipDrag(clip, $event)" @dblclick.stop="splitClipAt(clip)" :class="selectedClip?.id === clip.id ? 'ring-2 ring-sky-400 shadow-lg shadow-sky-500/30 z-10' : ''" class="absolute top-1 sm:top-1.5 bottom-1 sm:bottom-1.5 rounded-md flex items-center px-1 sm:px-2 cursor-grab active:cursor-grabbing overflow-hidden shadow-sm group/clip transition-all" :style="`left: ${clip.start * 100 * zoom}px; width: ${clip.duration * 100 * zoom}px; background: linear-gradient(135deg, ${clip.color}, ${adjustColor(clip.color, -30)}); border: 1px solid ${adjustColor(clip.color, 30)}`">
                                        <div class="flex-1 truncate">
                                            <span class="text-[9px] sm:text-[11px] font-bold truncate text-white drop-shadow-md" x-text="clip.name"></span>
                                            <span x-show="clip.transition !== 'none'" class="text-[8px] sm:text-[9px] bg-black/40 px-0.5 sm:px-1 rounded ml-0.5 sm:ml-1" x-text="clip.transition"></span>
                                        </div>
                                        <button @click.stop="deleteSpecificClip(clip)" class="absolute top-0 right-0.5 sm:right-1 text-white/50 hover:text-red-400 opacity-0 group-hover/clip:opacity-100 transition"><svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                        <div @mousedown.stop="startResize(clip, $event)" class="absolute right-0 top-0 bottom-0 w-1.5 sm:w-2 cursor-ew-resize bg-white/0 group-hover/clip:bg-white/30 hover:bg-white/50 transition"></div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== RIGHT PANEL INLINE (Inspector) ===================== -->
        <div class="shrink-0 overflow-hidden transition-all duration-300 ease-in-out bg-white dark:bg-slate-900 border-l border-gray-200 dark:border-slate-700/50 flex flex-col" :class="rightPanelOpen ? 'w-80 sm:w-96' : 'w-0 border-l-0'">
            <!-- Fixed width inner container -->
            <div class="w-80 sm:w-96 h-full flex flex-col">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-slate-700/50 shrink-0">
                    <h2 class="text-sm font-bold text-gray-800 dark:text-slate-200 flex items-center gap-2"><span class="text-sky-500">⚙️</span> Inspector</h2>
                    <button @click="rightPanelOpen = false" class="p-1 text-gray-400 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <template x-if="selectedClip">
                        <div class="p-4 space-y-5">
                            <div class="flex items-center gap-2 bg-gray-50 dark:bg-slate-800/50 p-2 rounded-lg border border-gray-200 dark:border-slate-700/50">
                                <div class="w-4 h-4 rounded-sm shrink-0 shadow-inner" :style="`background-color: ${selectedClip.color}`"></div>
                                <input type="text" x-model="selectedClip.name" @input="saveHistory()" class="bg-transparent px-2 py-1 rounded text-sm w-full capitalize border border-transparent focus:border-sky-500 focus:outline-none focus:bg-white dark:focus:bg-slate-900 transition text-gray-900 dark:text-white">
                                <button @click="deleteSelectedClip(); rightPanelOpen = false" class="text-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/20 p-1.5 shrink-0 rounded-md transition" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div><label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-1">Start (s)</label><input type="number" x-model.number="selectedClip.start" min="0" step="0.5" @input="saveHistory()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg px-2 py-1.5 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition"></div>
                                <div><label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-1">Duration (s)</label><input type="number" x-model.number="selectedClip.duration" min="0.5" step="0.5" @input="saveHistory()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg px-2 py-1.5 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition"></div>
                            </div>

                            <!-- Video/Image Effects -->
                            <template x-if="selectedClip.type === 'video' || selectedClip.type === 'image'">
                                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700/50">
                                    <h4 class="text-xs font-bold text-gray-700 dark:text-slate-300 flex items-center gap-1">🎬 Effects</h4>
                                    <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Zoom</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="(selectedClip.zoom || 1).toFixed(1) + 'x'"></span></label><input type="range" x-model="selectedClip.zoom" min="1" max="3" step="0.1" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-2">Playback Speed</label>
                                        <div class="grid grid-cols-4 gap-1.5">
                                            <button type="button" @click="selectedClip.speed = 0.5; saveHistory()" :class="selectedClip.speed == 0.5 ? 'bg-sky-100 dark:bg-sky-500/20 border-sky-500 text-sky-700 dark:text-sky-300' : 'bg-white dark:bg-slate-800/50 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400'" class="border rounded-md py-1 text-[10px] font-bold transition">0.5x</button>
                                            <button type="button" @click="selectedClip.speed = 1; saveHistory()" :class="selectedClip.speed == 1 ? 'bg-sky-100 dark:bg-sky-500/20 border-sky-500 text-sky-700 dark:text-sky-300' : 'bg-white dark:bg-slate-800/50 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400'" class="border rounded-md py-1 text-[10px] font-bold transition">1x</button>
                                            <button type="button" @click="selectedClip.speed = 1.5; saveHistory()" :class="selectedClip.speed == 1.5 ? 'bg-sky-100 dark:bg-sky-500/20 border-sky-500 text-sky-700 dark:text-sky-300' : 'bg-white dark:bg-slate-800/50 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400'" class="border rounded-md py-1 text-[10px] font-bold transition">1.5x</button>
                                            <button type="button" @click="selectedClip.speed = 2; saveHistory()" :class="selectedClip.speed == 2 ? 'bg-sky-100 dark:bg-sky-500/20 border-sky-500 text-sky-700 dark:text-sky-300' : 'bg-white dark:bg-slate-800/50 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400'" class="border rounded-md py-1 text-[10px] font-bold transition">2x</button>
                                        </div>
                                        <input type="hidden" x-model="selectedClip.speed">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-2">Color Filter</label>
                                        <div class="grid grid-cols-3 gap-1.5">
                                            <button type="button" @click="selectedClip.filter = 'none'; saveHistory()" :class="selectedClip.filter === 'none' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">None</button>
                                            <button type="button" @click="selectedClip.filter = 'grayscale(100%)'; saveHistory()" :class="selectedClip.filter === 'grayscale(100%)' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">B&W</button>
                                            <button type="button" @click="selectedClip.filter = 'sepia(100%)'; saveHistory()" :class="selectedClip.filter === 'sepia(100%)' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">Sepia</button>
                                            <button type="button" @click="selectedClip.filter = 'saturate(200%) contrast(1.2)' ; saveHistory()" :class="selectedClip.filter === 'saturate(200%) contrast(1.2)' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">Vivid</button>
                                            <button type="button" @click="selectedClip.filter = 'contrast(1.25) saturate(0.8) brightness(1.1)'; saveHistory()" :class="selectedClip.filter === 'contrast(1.25) saturate(0.8) brightness(1.1)' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">Warm</button>
                                            <button type="button" @click="selectedClip.filter = 'saturate(0.8) brightness(1.2) contrast(0.9)'; saveHistory()" :class="selectedClip.filter === 'saturate(0.8) brightness(1.2) contrast(0.9)' ? 'border-sky-500' : 'border-gray-200 dark:border-slate-700'" class="border rounded-md py-1.5 text-[9px] font-medium bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-300 transition">Cool</button>
                                        </div>
                                        <input type="hidden" x-model="selectedClip.filter">
                                    </div>
                                    <label class="flex items-center gap-2 cursor-pointer bg-gray-50 dark:bg-slate-800/50 p-2 rounded-md border border-gray-200 dark:border-slate-700/50"><input type="checkbox" x-model="selectedClip.mirror" @change="saveHistory()" class="rounded bg-gray-100 dark:bg-slate-700 border-gray-300 dark:border-slate-600 text-sky-500 focus:ring-sky-500"><span class="text-[11px] text-gray-700 dark:text-slate-300">Mirror Horizontal</span></label>
                                </div>
                            </template>

                            <!-- Text Properties -->
                            <template x-if="selectedClip.type === 'text'">
                                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700/50">
                                    <h4 class="text-xs font-bold text-gray-700 dark:text-slate-300 flex items-center gap-1">📝 Text</h4>
                                    <textarea x-model="selectedClip.content" rows="3" @input="saveHistory()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none resize-none transition"></textarea>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-1">Font Family</label>
                                        <select x-model="selectedClip.fontFamily" @change="saveHistory()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg px-2 py-2 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition">
                                            <option value="sans-serif">Sans Serif</option><option value="serif">Serif</option><option value="monospace">Monospace</option>
                                            <option value="Arial, sans-serif">Arial</option><option value="'Arial Black', sans-serif">Arial Black</option>
                                            <option value="Georgia, serif">Georgia</option><option value="'Times New Roman', serif">Times New Roman</option>
                                            <option value="'Courier New', monospace">Courier New</option><option value="Impact, sans-serif">Impact</option>
                                            <option value="'Trebuchet MS', sans-serif">Trebuchet MS</option><option value="Verdana, sans-serif">Verdana</option>
                                            <option value="'Comic Sans MS', cursive">Comic Sans MS</option><option value="cursive">Cursive</option>
                                        </select>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-slate-800/50 rounded-lg p-3 border border-gray-200 dark:border-slate-700/50 shadow-inner">
                                        <p class="text-[9px] text-gray-400 dark:text-slate-500 mb-1 uppercase tracking-wider">Preview</p>
                                        <p class="text-gray-900 dark:text-white truncate" :style="`font-family: ${selectedClip.fontFamily || 'sans-serif'}; font-size: ${Math.min(selectedClip.fontSize, 28)}px`" x-text="selectedClip.content || 'Sample Text'"></p>
                                    </div>
                                    <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Font Size</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="selectedClip.fontSize + 'px'"></span></label><input type="range" x-model="selectedClip.fontSize" min="12" max="120" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><label class="block text-[10px] font-semibold text-gray-500 dark:text-slate-400 mb-1">Color</label><input type="color" x-model="selectedClip.fontColor" class="w-full h-9 bg-gray-50 dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg cursor-pointer"></div>
                                        <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Opacity</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="Math.round((selectedClip.opacity || 1) * 100) + '%'"></span></label><input type="range" x-model="selectedClip.opacity" min="0" max="1" step="0.1" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer mt-2"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>X Position</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="(selectedClip.x || 0) + '%'"></span></label><input type="range" x-model="selectedClip.x" min="-50" max="50" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                                        <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Y Position</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="(selectedClip.y || 0) + '%'"></span></label><input type="range" x-model="selectedClip.y" min="-50" max="50" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                                    </div>
                                </div>
                            </template>

                            <!-- Transition -->
                            <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700/50">
                                <h4 class="text-xs font-bold text-gray-700 dark:text-slate-300 flex items-center gap-1">🔀 Transition</h4>
                                <select x-model="selectedClip.transition" @change="saveHistory()" class="w-full bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-lg px-2 py-2 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition">
                                    <option value="none">None</option><option value="fade">Fade</option><option value="slideLeft">Slide Left</option><option value="zoomIn">Zoom In</option>
                                </select>
                                <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Duration</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="selectedClip.transitionDuration + 's'"></span></label><input type="range" x-model="selectedClip.transitionDuration" min="0.1" max="2" step="0.1" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                            </div>

                            <!-- Audio Properties -->
                            <template x-if="selectedClip.type === 'audio'">
                                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700/50">
                                    <h4 class="text-xs font-bold text-gray-700 dark:text-slate-300 flex items-center gap-1">🔊 Audio</h4>
                                    <div><label class="flex justify-between text-[10px] text-gray-500 dark:text-slate-400 mb-1"><span>Volume</span><span class="font-mono text-sky-600 dark:text-sky-400" x-text="Math.round((selectedClip.volume || 1) * 100) + '%'"></span></label><input type="range" x-model="selectedClip.volume" min="0" max="1" step="0.1" @input="saveHistory()" class="w-full h-1.5 rounded-full accent-sky-500 bg-gray-200 dark:bg-slate-700 cursor-pointer"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="!selectedClip">
                        <div class="p-8 text-center mt-20">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                            <p class="text-gray-400 dark:text-slate-500 text-sm">Select a clip on the timeline to edit its properties</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div> <!-- End Main Content Wrapper -->

    <!-- EXPORT MODAL -->
    <div x-show="showExportModal" class="fixed inset-0 bg-black/40 dark:bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display:none;">
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700/50 rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 transition-colors">
            <h3 class="text-xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-slate-400 bg-clip-text text-transparent">Export Video</h3>
            <div class="grid grid-cols-3 gap-3 mb-6">
                <button @click="exportFormat = 'mp4'" :class="exportFormat === 'mp4' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 shadow-[0_0_15px_rgba(14,165,233,0.2)]' : 'border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 hover:border-gray-300 dark:hover:border-slate-600'" class="border rounded-xl p-4 text-center transition-all"><p class="font-bold text-sm">MP4</p><p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">Social</p></button>
                <button @click="exportFormat = 'webm'" :class="exportFormat === 'webm' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 shadow-[0_0_15px_rgba(14,165,233,0.2)]' : 'border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 hover:border-gray-300 dark:hover:border-slate-600'" class="border rounded-xl p-4 text-center transition-all"><p class="font-bold text-sm">WebM</p><p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">Web</p></button>
                <button @click="exportFormat = 'gif'" :class="exportFormat === 'gif' ? 'border-sky-500 bg-sky-50 dark:bg-sky-500/10 shadow-[0_0_15px_rgba(14,165,233,0.2)]' : 'border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 hover:border-gray-300 dark:hover:border-slate-600'" class="border rounded-xl p-4 text-center transition-all"><p class="font-bold text-sm">GIF</p><p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1">Loop</p></button>
            </div>
            <div class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-xl text-xs text-gray-600 dark:text-slate-400 mb-6 border border-gray-200 dark:border-slate-700/50"><p class="font-bold text-gray-900 dark:text-slate-200 mb-1">⚡ Server Rendering Required</p><p>20 credits will be deducted. FFmpeg will process your project in the cloud.</p></div>
            <div class="flex justify-end gap-3">
                <button @click="showExportModal = false" class="px-5 py-2.5 text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition font-medium">Cancel</button>
                <button @click="renderVideo()" class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-400 hover:to-rose-500 rounded-xl text-sm font-bold transition shadow-lg shadow-red-500/20 text-white">Render (20 💎)</button>
            </div>
        </div>
    </div>

    <div x-show="toast" x-transition class="fixed bottom-6 right-6 bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-bold z-50 border border-sky-400/30"><span x-text="toastMsg"></span></div>

    <form id="renderForm" action="{{ route('ai.video.generate') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="project_id" :value="projectId" />
        <input type="hidden" name="format" :value="exportFormat" />
    </form>
</div>

<script>
function videoEditor(initialProject) {
    return {
        projectId: initialProject?.id || null,
        projectName: initialProject?.prompt || 'Untitled Project',
        leftTab: 'ai', isPlaying: false, currentTime: 0, duration: 30, zoom: 1,
        showExportModal: false, exportFormat: 'mp4',
        isRecordingVoice: false, audioUrl: '', aiPrompt: '',
        isSaving: false, justSaved: false, isMuted: false,
        masterVolume: 1,
        selectedClip: null, isDragging: false, isResizing: false, dragData: null,
        history: [], historyIndex: -1, toast: false, toastMsg: '',
        uploadedFiles: [], draggedMedia: null, dragOverTrackId: null,

        leftPanelOpen: false,
        rightPanelOpen: false,

        timelineHeight: 220,
        isResizingTimeline: false,
        resizeTimelineStartY: 0,
        resizeTimelineStartH: 0,

        tracks: initialProject?.project_data?.tracks || [
            { id: 1, type: 'video', clips: [
                { id: 1, name: 'Intro', type: 'video', start: 0, duration: 5, color: '#2563eb', opacity: 1, zoom: 1, mirror: false, speed: 1, filter: 'none', transition: 'fade', transitionDuration: 0.5, src: '' },
                { id: 2, name: 'Product Shot', type: 'video', start: 5, duration: 8, color: '#3b82f6', opacity: 1, zoom: 1, mirror: false, speed: 1, filter: 'none', transition: 'none', transitionDuration: 0.5, src: '' }
            ]},
            { id: 2, type: 'audio', clips: [
                { id: 3, name: 'BGM', type: 'audio', start: 0, duration: 20, color: '#16a34a', volume: 1 }
            ]}
        ],

        init() {
            this.saveHistory();
            setInterval(() => {
                if (this.isPlaying) {
                    this.currentTime += 0.1;
                    this.recalculateDuration();
                    if (this.currentTime >= this.duration) { this.isPlaying = false; this.currentTime = 0; }
                    this.syncVideos();
                } else { this.pauseVideos(); }
            }, 100);

            window.addEventListener('mousemove', (e) => {
                if (this.isDragging && this.dragData) {
                    const d = (e.clientX - this.dragData.startX) / (100 * this.zoom);
                    this.dragData.clip.start = Math.max(0, this.dragData.originalStart + d);
                }
                if (this.isResizing && this.dragData) {
                    const d = (e.clientX - this.dragData.startX) / (100 * this.zoom);
                    this.dragData.clip.duration = Math.max(0.5, this.dragData.originalDuration + d);
                }
                if (this.isResizingTimeline) {
                    const d = this.resizeTimelineStartY - e.clientY;
                    this.timelineHeight = Math.max(100, Math.min(500, this.resizeTimelineStartH + d));
                }
            });
            window.addEventListener('mouseup', () => {
                if (this.isDragging || this.isResizing) { this.isDragging = false; this.isResizing = false; this.dragData = null; this.saveHistory(); }
                if (this.isResizingTimeline) { this.isResizingTimeline = false; }
            });
        },

        enhancePrompt() {
            if(!this.aiPrompt.trim()) this.aiPrompt = "Cinematic video";
            const keywords = ", highly detailed, 4k resolution, cinematic lighting, smooth camera movement, professional";
            if(!this.aiPrompt.includes(keywords)) this.aiPrompt += keywords;
            this.showToast('Prompt enhanced!');
        },

        toggleFullscreen() {
            const el = document.getElementById('preview-canvas');
            if (!document.fullscreenElement) { el.requestFullscreen().catch(err => {}); }
            else { document.exitFullscreen(); }
        },

        adjustColor(hex, amount) {
            if(!hex) return '#000000';
            let r = parseInt(hex.slice(1, 3), 16) + amount;
            let g = parseInt(hex.slice(3, 5), 16) + amount;
            let b = parseInt(hex.slice(5, 7), 16) + amount;
            r = Math.max(0, Math.min(255, r)); g = Math.max(0, Math.min(255, g)); b = Math.max(0, Math.min(255, b));
            return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
        },

        togglePanel(side) {
            if (side === 'left') this.leftPanelOpen = !this.leftPanelOpen;
            else this.rightPanelOpen = !this.rightPanelOpen;
        },

        closeAllPanels() { this.leftPanelOpen = false; this.rightPanelOpen = false; },

        selectClip(clip) {
            this.selectedClip = clip;
            this.rightPanelOpen = true;
        },

        startResizeTimeline(e) { this.isResizingTimeline = true; this.resizeTimelineStartY = e.clientY; this.resizeTimelineStartH = this.timelineHeight; },

        syncVideos() {
            const el = document.getElementById('preview-canvas'); if (!el) return;
            el.querySelectorAll('video').forEach(v => {
                const c = this.tracks.flatMap(t => t.clips).find(cl => cl.id == v.dataset.clipId);
                if (c) {
                    const t = this.currentTime - c.start;
                    if (Math.abs(v.currentTime - t) > 0.5) v.currentTime = t;
                    if (v.paused) v.play().catch(() => {});
                    v.volume = this.isMuted ? 0 : Math.min(1, this.masterVolume * (c.volume || 1));
                    v.playbackRate = c.speed || 1;
                }
            });
        },
        pauseVideos() { const el = document.getElementById('preview-canvas'); if (!el) return; el.querySelectorAll('video').forEach(v => { if (!v.paused) v.pause(); }); },

        getActiveClips() { let a = []; this.tracks.forEach(t => t.clips.forEach(c => { if (this.currentTime >= c.start && this.currentTime <= c.start + c.duration) a.push(c); })); return a; },
        recalculateDuration() { let m = 10; this.tracks.forEach(t => t.clips.forEach(c => { if (c.start + c.duration > m) m = c.start + c.duration; })); this.duration = m + 2; },
        seekTo(e) { const r = e.currentTarget.getBoundingClientRect(); this.currentTime = Math.max(0, (e.clientX - r.left) / (100 * this.zoom)); this.isPlaying = false; this.syncVideos(); },
        seekPreview(e) { const r = e.currentTarget.getBoundingClientRect(); this.currentTime = Math.max(0, ((e.clientX - r.left) / r.width) * this.duration); this.isPlaying = false; this.syncVideos(); },
        formatTime(s) { const m = Math.floor(s/60); const sec = Math.floor(s%60); return `${m.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`; },
        showToast(msg) { this.toastMsg = msg; this.toast = true; setTimeout(() => this.toast = false, 2000); },

        async generateAiVideo() {
            if(!this.aiPrompt.trim()) return; this.isSaving = true;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch('/ai/video/ai-generate', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, body: JSON.stringify({ prompt: this.aiPrompt }) });
                const data = await res.json();
                if (!res.ok || !data.success) { this.showToast(data.message || 'Failed'); this.isSaving = false; return; }
                this.showToast('5 💎 deducted. Generating...');
            } catch (e) { this.showToast('Failed'); this.isSaving = false; return; }
            this.isSaving = false;
            this.tracks = this.tracks.filter(t => t.type !== 'video');
            this.addTrack('video'); let vt = this.tracks[this.tracks.length - 1];
            const scenes = [ { name: 'AI Scene 1', dur: 3, color: '#0ea5e9' }, { name: 'AI Scene 2', dur: 4, color: '#2563eb' }, { name: 'AI Text', dur: 3, color: '#7c3aed', type: 'text' } ];
            let st = 0;
            scenes.forEach((s, i) => { let c = { id: Date.now() + i, name: s.name, type: s.type || 'video', start: st, duration: s.dur, color: s.color, opacity: 1, zoom: 1, mirror: false, speed: 1, filter: 'none', transition: 'fade', transitionDuration: 0.5, src: '' }; if(s.type === 'text') { c.content = this.aiPrompt.substring(0, 30) + '...'; c.fontSize = 32; c.fontColor = '#ffffff'; c.fontFamily = 'sans-serif'; c.x = 0; c.y = 0; } vt.clips.push(c); st += s.dur; });
            this.addAudioClip('bgm'); this.aiPrompt = ''; this.recalculateDuration(); this.saveHistory();
        },

        handleFileUpload(e) { const f = e.target.files[0]; if (!f) return; this.uploadedFiles.push({ id: Date.now(), name: f.name, src: URL.createObjectURL(f), type: f.type.startsWith('video') ? 'video' : 'image' }); },
        removeUploadedFile(id) { this.uploadedFiles = this.uploadedFiles.filter(f => f.id !== id); },
        handleAudioUpload(e) { const f = e.target.files[0]; if (!f) return; this.addAudioClip('custom', f.name, URL.createObjectURL(f)); },
        addAudioFromUrl() { if(!this.audioUrl.trim()) return; this.addAudioClip('custom', 'Web Audio', this.audioUrl); this.audioUrl = ''; },
        addUploadedMediaToTimeline(file) {
            let t = this.tracks.find(t => t.type === 'video'); if (!t) { this.addTrack('video'); t = this.tracks[this.tracks.length - 1]; } const last = t.clips.length > 0 ? t.clips[t.clips.length - 1] : null;
            const c = { id: Date.now(), name: file.name, type: file.type, start: last ? last.start + last.duration : 0, duration: file.type === 'video' ? 10 : 5, color: file.type === 'video' ? '#0f766e' : '#7e22ce', opacity: 1, zoom: 1, mirror: false, speed: 1, filter: 'none', transition: 'fade', transitionDuration: 0.5, src: file.src };
            t.clips.push(c); this.selectedClip = c; this.recalculateDuration(); this.saveHistory(); this.showToast('Added'); this.leftPanelOpen = false;
        },

        startMediaDrag(file, e) { this.draggedMedia = file; e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', file.id); },
        onDropToTrack(track, e) {
            this.dragOverTrackId = null; if (!this.draggedMedia) return;
            if ((track.type === 'video' && (this.draggedMedia.type === 'video' || this.draggedMedia.type === 'image')) || (track.type === 'audio' && this.draggedMedia.type === 'audio')) {
                const rect = e.currentTarget.getBoundingClientRect(); const st = Math.max(0, (e.clientX - rect.left) / (100 * this.zoom));
                const c = { id: Date.now(), name: this.draggedMedia.name, type: this.draggedMedia.type, start: st, duration: this.draggedMedia.type === 'video' ? 10 : (this.draggedMedia.type === 'audio' ? 30 : 5), color: this.draggedMedia.type === 'video' ? '#0f766e' : (this.draggedMedia.type === 'audio' ? '#16a34a' : '#7e22ce'), opacity: 1, zoom: 1, mirror: false, speed: 1, filter: 'none', transition: 'fade', transitionDuration: 0.5, src: this.draggedMedia.src, volume: this.draggedMedia.type === 'audio' ? 1 : undefined };
                track.clips.push(c); this.selectedClip = c; this.recalculateDuration(); this.saveHistory();
            } this.draggedMedia = null;
        },

        toggleVoiceRecord() { this.isRecordingVoice = !this.isRecordingVoice; if (this.isRecordingVoice) { this.showToast('Recording...'); } else { this.showToast('Voice added'); this.addAudioClip('voiceover'); } },
        addTrack(type) { this.tracks.push({ id: Date.now(), type, clips: [] }); this.saveHistory(); },
        removeTrack(id) { if(confirm('Delete track?')) { this.tracks = this.tracks.filter(t => t.id !== id); this.selectedClip = null; this.saveHistory(); } },

        addTextClip(text, size, color, font) {
            let t = this.tracks.find(t => t.type === 'video'); if (!t) { this.addTrack('video'); t = this.tracks[this.tracks.length - 1]; }
            const c = { id: Date.now(), name: text || 'Text Overlay', type: 'text', start: this.currentTime, duration: 3, color: '#7c3aed', content: text || 'Your Text', fontSize: size || 32, fontColor: color || '#ffffff', fontFamily: font || 'sans-serif', opacity: 1, x: 0, y: 0, transition: 'none', transitionDuration: 0.5 };
            t.clips.push(c); this.selectedClip = c; this.saveHistory();
        },

        addAudioClip(type, name = null, src = null) { let t = this.tracks.find(t => t.type === 'audio'); if (!t) { this.addTrack('audio'); t = this.tracks[this.tracks.length - 1]; } const last = t.clips.length > 0 ? t.clips[t.clips.length - 1] : null; const c = { id: Date.now(), name: name || (type === 'bgm' ? '🎵 BGM' : '🎙 Voice'), type: 'audio', start: last ? last.start + last.duration : 0, duration: type === 'voiceover' ? 10 : 30, color: type === 'bgm' ? '#16a34a' : '#ca8a04', volume: 1, src: src || '', transition: 'none', transitionDuration: 0.5 }; t.clips.push(c); this.selectedClip = c; this.recalculateDuration(); this.saveHistory(); },

        deleteSelectedClip() { if(!this.selectedClip) return; this.deleteSpecificClip(this.selectedClip); },
        deleteSpecificClip(clip) { this.tracks.forEach(t => t.clips = t.clips.filter(c => c.id !== clip.id)); if(this.selectedClip?.id === clip.id) { this.selectedClip = null; this.rightPanelOpen = false; } this.recalculateDuration(); this.saveHistory(); },
        splitClip() { if (!this.selectedClip) return; const c = this.selectedClip; if (this.currentTime > c.start && this.currentTime < c.start + c.duration) { const od = c.duration; c.duration = this.currentTime - c.start; let n = JSON.parse(JSON.stringify(c)); n.id = Date.now(); n.start = this.currentTime; n.duration = od - c.duration; n.name += ' (Split)'; let t = this.tracks.find(t => t.clips.some(cl => cl.id === c.id)); if (t) t.clips.push(n); this.selectedClip = n; this.saveHistory(); } },
        splitClipAt(clip) { this.selectedClip = clip; this.splitClip(); },

        startClipDrag(clip, e) { this.isDragging = true; this.selectedClip = clip; this.dragData = { clip, startX: e.clientX, originalStart: clip.start }; },
        startResize(clip, e) { this.isResizing = true; this.selectedClip = clip; this.dragData = { clip, startX: e.clientX, originalDuration: clip.duration }; },

        saveHistory() { this.history = this.history.slice(0, this.historyIndex + 1); this.history.push(JSON.parse(JSON.stringify(this.tracks))); this.historyIndex = this.history.length - 1; },
        undo() { if (this.historyIndex > 0) { this.historyIndex--; this.tracks = JSON.parse(JSON.stringify(this.history[this.historyIndex])); this.selectedClip = null; this.rightPanelOpen = false; } },
        redo() { if (this.historyIndex < this.history.length - 1) { this.historyIndex++; this.tracks = JSON.parse(JSON.stringify(this.history[this.historyIndex])); this.selectedClip = null; this.rightPanelOpen = false; } },

        async autosave() { this.isSaving = true; this.justSaved = false; try { const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); const res = await fetch('{{ route("ai.video.autosave") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify({ project_id: this.projectId, prompt: this.projectName, project_data: { tracks: this.tracks } }) }); const data = await res.json(); if(data.project_id && !this.projectId) this.projectId = data.project_id; this.isSaving = false; this.justSaved = true; setTimeout(() => this.justSaved = false, 2000); } catch (e) { this.isSaving = false; this.showToast('Save failed!'); } },
        renderVideo() { this.showExportModal = false; if(confirm(`Render ${this.exportFormat.toUpperCase()}? 20 credits.`)) { this.autosave(); document.getElementById('renderForm').submit(); } }
    }
}
</script>
@endsection
