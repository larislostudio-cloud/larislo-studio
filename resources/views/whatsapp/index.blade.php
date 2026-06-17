@extends('layouts.app')

@section('title', 'WhatsApp AI Bot - Dashboard')

@section('content')

@php
// Siapkan data kontak dari $chats (hindari closure di dalam @json())
 $contactsJson = [];
 $chatDataJson = [];

if (isset($chats) && $chats->count() > 0) {
    foreach ($chats as $phone => $messages) {
        $lastMsg = $messages->first();
        $contactsJson[] = [
            'id' => $phone,
            'name' => $phone,
            'avatar' => substr($phone, -2),
            'lastMsg' => \Illuminate\Support\Str::limit($lastMsg->message, 30),
            'time' => $lastMsg->created_at->format('H:i'),
            'unread' => $messages->where('direction', 'in')->where('is_read', false)->count(),
            'online' => false,
            'bot' => $lastMsg->direction === 'out' && $lastMsg->created_at->diffInSeconds() < 60,
            'color' => 'from-emerald-400 to-teal-500',
        ];

        $chatDataJson[$phone] = $messages->reverse()->map(function ($m) {
            return [
                'type' => $m->direction === 'in' ? 'in' : 'out',
                'text' => $m->message,
                'time' => $m->created_at->format('H:i'),
                'bot' => $m->direction === 'out' && ($m->is_ai ?? false),
            ];
        })->prepend([
            'type' => 'date',
            'text' => $messages->first()->created_at->format('d M Y'),
        ])->values()->toArray();
    }
}
@endphp

<div id="waApp" class="h-screen flex flex-col bg-gray-50 dark:bg-slate-900 transition-colors duration-500 overflow-hidden">

    <!-- ==================== TOP BAR ==================== -->
    <header class="relative z-30 bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 dark:from-slate-800 dark:via-slate-800 dark:to-slate-800 text-white px-4 md:px-6 py-3 flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="p-2 hover:bg-white/10 rounded-lg transition" title="Toggle Contacts">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="w-9 h-9 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center font-black text-sm">LB</div>
            <div>
                <h1 class="font-bold text-base leading-tight">Larislo Bot</h1>
                <div class="flex items-center gap-1.5">
                    <span id="botStatusDot" class="w-2 h-2 rounded-full bg-green-300 pulse-green"></span>
                    <span id="botStatusText" class="text-xs text-emerald-100">Active</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 md:gap-3">
            <div class="hidden sm:flex items-center gap-1.5 bg-white/15 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6c.304 0 .792.193 1.264.979a1 1 0 001.715-1.029C12.279 4.784 11.232 4 10 4s-2.279.784-2.979 1.95c-.285.475-.507 1-.67 1.55H6a1 1 0 000 2h.013a9.358 9.358 0 000 1H6a1 1 0 100 2h.351c.163.55.385 1.075.67 1.55C7.721 15.216 8.768 16 10 16s2.279-.784 2.979-1.95a1 1 0 10-1.715-1.029C10.792 13.807 10.304 14 10 14c-.304 0-.792-.193-1.264-.979a5.4 5.4 0 01-.408-.821h1.672a1 1 0 100-2H8.004a7.3 7.3 0 010-1h2.028a1 1 0 100-2H8.328c.126-.297.26-.568.408-.821z"/></svg>
                <span id="creditCount">{{ $credits ?? 150 }}</span> Kredit
            </div>
            <button onclick="toggleBot()" id="botToggleBtn" class="flex items-center gap-1.5 bg-white/15 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold hover:bg-white/25 transition" title="Toggle Bot">
                <span id="botToggleIcon">🤖</span>
                <span id="botToggleLabel" class="hidden sm:inline">Bot On</span>
            </button>
            <button class="relative p-2 hover:bg-white/10 rounded-lg transition" onclick="showToast('Tidak ada notifikasi baru', 'info')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-[10px] font-bold rounded-full flex items-center justify-center">3</span>
            </button>
            <button onclick="toggleDarkMode()" class="p-2 hover:bg-white/10 rounded-lg transition" title="Toggle Dark Mode">
                <svg id="sunIcon" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg id="moonIcon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>
            <button onclick="toggleToolsPanel()" class="p-2 hover:bg-white/10 rounded-lg transition" title="AI Tools">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </button>
        </div>
    </header>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div class="flex flex-1 overflow-hidden relative">

        <!-- ===== LEFT SIDEBAR ===== -->
        <div id="sidebarWrap" class="shrink-0 overflow-hidden">
            <aside id="sidebar" class="w-80 h-full flex flex-col bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700">
                <div class="lg:hidden flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                    <span class="font-bold text-gray-900 dark:text-white">Pesan</span>
                    <button onclick="toggleSidebar()" class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-3 border-b border-gray-100 dark:border-slate-700">
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="searchContacts" oninput="filterContacts()" placeholder="Cari kontak..." class="w-full pl-9 pr-4 py-2 bg-gray-100 dark:bg-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-gray-200 placeholder-gray-400 dark:placeholder-slate-500 transition">
                    </div>
                    <div class="flex gap-1 mt-2">
                        <button onclick="setContactFilter('all')" class="contact-filter-btn active text-xs px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-medium transition" data-filter="all">Semua</button>
                        <button onclick="setContactFilter('unread')" class="contact-filter-btn text-xs px-3 py-1 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition" data-filter="unread">Belum Dibaca</button>
                        <button onclick="setContactFilter('bot')" class="contact-filter-btn text-xs px-3 py-1 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition" data-filter="bot">Bot</button>
                    </div>
                </div>
                <div id="contactList" class="flex-1 overflow-y-auto custom-scroll"></div>
                <div class="sm:hidden p-3 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-slate-400">
                        <span class="text-amber-500 font-bold">{{ $credits ?? 150 }} Kredit</span> tersisa
                    </div>
                </div>
            </aside>
        </div>

        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-[24] transition-opacity duration-300 opacity-0 pointer-events-none" onclick="toggleSidebar()"></div>

        <!-- ===== CENTER: Chat Area ===== -->
        <main class="flex-1 flex flex-col bg-[#efeae2] dark:bg-slate-900 relative min-w-0">
            <div class="absolute inset-0 opacity-[0.04] dark:opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23000000&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <button id="openSidebarBtn" onclick="toggleSidebar()" class="hidden absolute left-0 top-1/2 -translate-y-1/2 z-20 w-7 h-20 bg-white dark:bg-slate-800 rounded-r-xl shadow-lg border border-l-0 border-gray-200 dark:border-slate-700 items-center justify-center hover:bg-emerald-50 dark:hover:bg-slate-700 group transition-all">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <button id="openToolsBtn" onclick="toggleToolsPanel()" class="hidden absolute right-0 top-1/2 -translate-y-1/2 z-20 w-7 h-20 bg-white dark:bg-slate-800 rounded-l-xl shadow-lg border border-r-0 border-gray-200 dark:border-slate-700 items-center justify-center hover:bg-emerald-50 dark:hover:bg-slate-700 group transition-all">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <!-- Chat Header -->
            <div class="relative z-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-slate-700 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div id="chatAvatar" class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm">--</div>
                        <span id="chatOnlineDot" class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-gray-400 border-2 border-white dark:border-slate-800 rounded-full"></span>
                    </div>
                    <div>
                        <h3 id="chatName" class="font-semibold text-gray-900 dark:text-white text-sm">Pilih Kontak</h3>
                        <p id="chatStatus" class="text-xs text-gray-500 dark:text-slate-400">Pilih kontak untuk mulai chat</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition" title="Cari pesan">
                        <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition" title="Info kontak">
                        <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chatMessages" class="relative z-10 flex-1 overflow-y-auto custom-scroll p-4 space-y-3">
                <div class="flex-1 flex flex-col items-center justify-center text-center p-8 h-full">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-4xl">💬</div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200 mb-2">Larislo WhatsApp Bot</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mb-6">Klik kontak di kiri untuk melihat percakapan atau kirim pesan manual.</p>
                </div>
            </div>

            <!-- Typing Indicator -->
            <div id="typingIndicator" class="relative z-10 hidden px-4 pb-1">
                <div class="inline-flex items-center gap-2 bg-white dark:bg-slate-700 rounded-2xl px-4 py-2.5 shadow-sm">
                    <div class="flex gap-1">
                        <span class="typing-dot w-1.5 h-1.5 bg-gray-400 dark:bg-slate-400 rounded-full"></span>
                        <span class="typing-dot w-1.5 h-1.5 bg-gray-400 dark:bg-slate-400 rounded-full"></span>
                        <span class="typing-dot w-1.5 h-1.5 bg-gray-400 dark:bg-slate-400 rounded-full"></span>
                    </div>
                    <span class="text-xs text-gray-400 dark:text-slate-400">Bot sedang mengetik...</span>
                </div>
            </div>

            <!-- Quick Replies -->
            <div id="quickReplies" class="relative z-10 px-4 py-2 flex gap-2 overflow-x-auto custom-scroll">
                <button onclick="sendQuickReply('Masih ready kak?')" class="shrink-0 text-xs px-3 py-1.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-full text-gray-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-300 hover:text-emerald-700 dark:hover:text-emerald-300 transition">Masih ready kak?</button>
                <button onclick="sendQuickReply('Berapa harganya?')" class="shrink-0 text-xs px-3 py-1.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-full text-gray-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-300 hover:text-emerald-700 dark:hover:text-emerald-300 transition">Berapa harganya?</button>
                <button onclick="sendQuickReply('Bisa COD?')" class="shrink-0 text-xs px-3 py-1.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-full text-gray-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-300 hover:text-emerald-700 dark:hover:text-emerald-300 transition">Bisa COD?</button>
                <button onclick="sendQuickReply('Oke, saya order')" class="shrink-0 text-xs px-3 py-1.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-full text-gray-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-300 hover:text-emerald-700 dark:hover:text-emerald-300 transition">Oke, saya order</button>
                <button onclick="sendQuickReply('Terima kasih')" class="shrink-0 text-xs px-3 py-1.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-full text-gray-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-300 hover:text-emerald-700 dark:hover:text-emerald-300 transition">Terima kasih</button>
            </div>

            <!-- Input Bar -->
            <div class="relative z-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg border-t border-gray-200 dark:border-slate-700 p-3">
                <div class="flex items-end gap-2">
                    <button class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition" title="Lampiran">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </button>
                    <div class="flex-1 relative">
                        <input type="text" id="messageInput" placeholder="Ketik pesan..." onkeydown="if(event.key==='Enter')sendMessage()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white placeholder-gray-400 dark:placeholder-slate-500 transition">
                    </div>
                    <button onclick="sendMessage()" class="p-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition shadow-lg shadow-emerald-600/30 active:scale-95" title="Kirim">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
                <div class="flex items-center gap-3 mt-2 px-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="aiAssistToggle" checked class="sr-only peer">
                            <div class="w-8 h-4 bg-gray-300 dark:bg-slate-600 rounded-full peer peer-checked:bg-emerald-500 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform"></div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-slate-400">AI Auto-Reply</span>
                    </label>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">|</span>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500">Bot akan otomatis membalas pesan masuk</span>
                </div>
            </div>
        </main>

        <!-- ===== RIGHT PANEL ===== -->
        <div id="toolsPanelWrap" class="shrink-0 overflow-hidden">
            <aside id="toolsPanel" class="w-[340px] h-full flex flex-col bg-white dark:bg-slate-800 border-l border-gray-200 dark:border-slate-700">
                <div class="xl:hidden flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                    <span class="font-bold text-gray-900 dark:text-white">AI Tools</span>
                    <button onclick="toggleToolsPanel()" class="p-1.5 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex border-b border-gray-200 dark:border-slate-700 overflow-x-auto custom-scroll">
                    <button onclick="setToolTab('training')" class="tool-tab active flex-1 min-w-0 px-3 py-3 text-xs font-semibold text-center border-b-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 transition" data-tab="training"><span class="block">🧠</span>Training</button>
                    <button onclick="setToolTab('knowledge')" class="tool-tab flex-1 min-w-0 px-3 py-3 text-xs font-semibold text-center border-b-2 border-transparent text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition" data-tab="knowledge"><span class="block">📚</span>Knowledge</button>
                    <button onclick="setToolTab('autoreply')" class="tool-tab flex-1 min-w-0 px-3 py-3 text-xs font-semibold text-center border-b-2 border-transparent text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition" data-tab="autoreply"><span class="block">⚡</span>Auto</button>
                    <button onclick="setToolTab('analytics')" class="tool-tab flex-1 min-w-0 px-3 py-3 text-xs font-semibold text-center border-b-2 border-transparent text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition" data-tab="analytics"><span class="block">📊</span>Stats</button>
                </div>

                <div class="flex-1 overflow-y-auto custom-scroll">
                    <!-- TRAINING TAB -->
                    <div id="tab-training" class="tool-tab-content p-4 space-y-4">
                        <form action="{{ route('whatsapp.train') }}" method="POST" id="trainForm">
                            @csrf
                            <button type="submit" onclick="startTraining(event)" class="w-full py-3 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-600/25 active:scale-[0.98] flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Train AI Sekarang
                                <span class="bg-white/20 text-[10px] px-2 py-0.5 rounded-full">-15 Kredit</span>
                            </button>
                        </form>
                        @if(session('error'))
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-xs text-red-600 dark:text-red-400">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs text-emerald-600 dark:text-emerald-400">{{ session('success') }}</div>
                        @endif

                        <div id="trainingProgress" class="hidden">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-gray-700 dark:text-slate-300">Training Progress</span>
                                <span id="trainingPercent" class="text-xs font-bold text-emerald-600 dark:text-emerald-400">0%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div id="trainingBar" class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-300" style="width:0%"></div>
                            </div>
                            <p id="trainingStatus" class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Menganalisis data produk...</p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3 text-center">
                                <p id="trainingCount" class="text-lg font-bold text-gray-900 dark:text-white">0</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400">Data Training</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3 text-center">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">92%</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400">Akurasi</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Tambah Data Training</h4>
                            <div class="space-y-2">
                                <input type="text" id="trainQuestion" placeholder="Pertanyaan / Keyword..." class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition">
                                <textarea id="trainAnswer" placeholder="Jawaban bot..." rows="2" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition resize-none"></textarea>
                                <select id="trainCategory" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition">
                                    <option value="produk">Produk</option>
                                    <option value="harga">Harga</option>
                                    <option value="pengiriman">Pengiriman</option>
                                    <option value="umum">Umum</option>
                                </select>
                                <button onclick="addTrainingData()" class="w-full py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg text-xs font-semibold hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition">+ Tambah Data</button>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Data Training Terbaru</h4>
                            <div id="trainingDataList" class="space-y-2"></div>
                        </div>
                    </div>

                    <!-- KNOWLEDGE TAB -->
                    <div id="tab-knowledge" class="tool-tab-content hidden p-4 space-y-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Basis Pengetahuan</h4>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 mb-3">Tambahkan informasi produk agar bot menjawab lebih akurat.</p>
                            <div class="space-y-2">
                                <input type="text" id="kbTitle" placeholder="Judul (misal: Kemeja Flanel)" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition">
                                <textarea id="kbContent" placeholder="Detail produk: harga, ukuran, stok, dll..." rows="3" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition resize-none"></textarea>
                                <button onclick="addKnowledge()" class="w-full py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg text-xs font-semibold hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition">+ Tambah Pengetahuan</button>
                            </div>
                        </div>
                        <div id="knowledgeList" class="space-y-2"></div>
                    </div>

                    <!-- AUTO-REPLY TAB -->
                    <div id="tab-autoreply" class="tool-tab-content hidden p-4 space-y-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Aturan Auto-Reply</h4>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 mb-3">Buat balasan otomatis berdasarkan kata kunci.</p>
                            <div class="space-y-2">
                                <input type="text" id="arKeyword" placeholder="Kata kunci (misal: harga)" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition">
                                <textarea id="arReply" placeholder="Balasan otomatis..." rows="2" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:text-white transition resize-none"></textarea>
                                <button onclick="addAutoReply()" class="w-full py-2 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-lg text-xs font-semibold hover:bg-amber-200 dark:hover:bg-amber-900/50 transition">+ Tambah Aturan</button>
                            </div>
                        </div>
                        <div id="autoReplyList" class="space-y-2"></div>
                    </div>

                    <!-- ANALYTICS TAB -->
                    <div id="tab-analytics" class="tool-tab-content hidden p-4 space-y-4">
                        <h4 class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Statistik Bot</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-3 border border-emerald-100 dark:border-emerald-800/30">
                                <p class="text-xl font-bold text-emerald-700 dark:text-emerald-300">148</p>
                                <p class="text-[10px] text-emerald-600/70 dark:text-emerald-400/70">Pesan Hari Ini</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-3 border border-blue-100 dark:border-blue-800/30">
                                <p class="text-xl font-bold text-blue-700 dark:text-blue-300">94%</p>
                                <p class="text-[10px] text-blue-600/70 dark:text-blue-400/70">Balasan Bot</p>
                            </div>
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-3 border border-amber-100 dark:border-amber-800/30">
                                <p class="text-xl font-bold text-amber-700 dark:text-amber-300">1.2s</p>
                                <p class="text-[10px] text-amber-600/70 dark:text-amber-400/70">Waktu Respon</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-3 border border-purple-100 dark:border-purple-800/30">
                                <p class="text-xl font-bold text-purple-700 dark:text-purple-300">4.8</p>
                                <p class="text-[10px] text-purple-600/70 dark:text-purple-400/70">Kepuasan</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3">
                            <p class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-3">Pesan 7 Hari Terakhir</p>
                            <div class="flex items-end gap-1.5 h-20">
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-400 dark:bg-emerald-500 rounded-t" style="height:60%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Sen</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-400 dark:bg-emerald-500 rounded-t" style="height:80%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Sel</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-400 dark:bg-emerald-500 rounded-t" style="height:45%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Rab</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-400 dark:bg-emerald-500 rounded-t" style="height:90%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Kam</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-400 dark:bg-emerald-500 rounded-t" style="height:70%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Jum</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-300 dark:bg-emerald-600 rounded-t" style="height:100%"></div><span class="text-[8px] text-gray-400 dark:text-slate-500">Sab</span></div>
                                <div class="flex-1 flex flex-col items-center gap-1"><div class="w-full bg-emerald-500 dark:bg-emerald-400 rounded-t animate-pulse" style="height:55%"></div><span class="text-[8px] text-emerald-500 font-bold">Min</span></div>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Pertanyaan Populer</p>
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between py-1.5 px-2.5 bg-gray-50 dark:bg-slate-700/50 rounded-lg"><span class="text-[11px] text-gray-600 dark:text-slate-300">Masih ready?</span><span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">42x</span></div>
                                <div class="flex items-center justify-between py-1.5 px-2.5 bg-gray-50 dark:bg-slate-700/50 rounded-lg"><span class="text-[11px] text-gray-600 dark:text-slate-300">Berapa harga?</span><span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">38x</span></div>
                                <div class="flex items-center justify-between py-1.5 px-2.5 bg-gray-50 dark:bg-slate-700/50 rounded-lg"><span class="text-[11px] text-gray-600 dark:text-slate-300">Bisa COD?</span><span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">27x</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
        <div id="toolsPanelOverlay" class="fixed inset-0 bg-black/50 z-[24] transition-opacity duration-300 opacity-0 pointer-events-none" onclick="toggleToolsPanel()"></div>
    </div>
</div>

<!-- ==================== MODAL: HUBUNGKAN WHATSAPP ==================== -->
<div id="activateBotModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeActivateModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 slide-up max-h-[90vh] overflow-y-auto">
        <button onclick="closeActivateModal()" class="absolute top-4 right-4 p-1 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="text-center mb-5">
            <div class="w-14 h-14 mx-auto mb-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center text-3xl">📱</div>
            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Hubungkan WhatsApp Anda</h3>
            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Ikuti 3 langkah mudah di bawah ini untuk mengaktifkan bot.</p>
        </div>

        <!-- PANDUAN VISUAL -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30 p-4 rounded-xl mb-5 text-xs text-amber-800 dark:text-amber-200 space-y-3">
            <p class="font-bold text-sm">🚀 Cara Mendapatkan Kode Koneksi:</p>

            <div class="flex gap-3">
                <span class="shrink-0 w-6 h-6 bg-amber-200 dark:bg-amber-800 text-amber-800 dark:text-amber-200 rounded-full flex items-center justify-center font-bold text-[11px]">1</span>
                <div>
                    <p class="font-semibold">Buka Website Fonnte</p>
                    <a href="https://fonnte.com" target="_blank" class="text-blue-600 dark:text-blue-400 underline hover:no-underline">Klik di sini untuk ke Fonnte.com</a> & daftar gratis.
                </div>
            </div>

            <div class="flex gap-3">
                <span class="shrink-0 w-6 h-6 bg-amber-200 dark:bg-amber-800 text-amber-800 dark:text-amber-200 rounded-full flex items-center justify-center font-bold text-[11px]">2</span>
                <div>
                    <p class="font-semibold">Scan QR Code</p>
                    <p>Buka aplikasi WhatsApp di HP Anda > Menu > Perangkat Tertaut > Scan QR di Fonnte.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <span class="shrink-0 w-6 h-6 bg-amber-200 dark:bg-amber-800 text-amber-800 dark:text-amber-200 rounded-full flex items-center justify-center font-bold text-[11px]">3</span>
                <div>
                    <p class="font-semibold">Copy Kode Koneksi</p>
                    <p>Di dashboard Fonnte, buka menu <strong>API Key</strong>, lalu klik <strong>Copy</strong>.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('whatsapp.settings.save') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1 block">Nama Toko / Bisnis</label>
                    <input type="text" name="store_name" value="{{ $bot->store_name ?? '' }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 dark:text-white" placeholder="Contoh: Toko Baju Larislo">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1 block">Nomor WhatsApp Bisnis</label>
                    <input type="text" name="phone_number" value="{{ $bot->phone_number ?? '' }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 dark:text-white" placeholder="Contoh: 6281234567890">
                    <p class="text-[10px] text-gray-400 mt-1">Gunakan format 62 (tanpa + atau 0 di depan)</p>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-700 dark:text-slate-300 mb-1 block">Kode Koneksi (API Key)</label>
                    <div class="relative">
                        <input type="password" id="apiKeyInput" name="api_key" value="{{ $bot->api_key ?? '' }}" required class="w-full px-4 py-2.5 pr-10 bg-gray-50 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 dark:text-white" placeholder="Paste kode dari Fonnte di sini...">
                        <button type="button" onclick="toggleApiKeyVisibility()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Kode ini digunakan agar bot bisa mengakses WA Anda.</p>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg text-[11px] text-blue-700 dark:text-blue-300">
                    <strong>🔗 Webhook URL:</strong> Setelah daftar Fonnte, masukkan URL ini di menu Webhook Fonnte Anda agar pesan masuk bisa dibaca bot:<br>
                    <code class="bg-white dark:bg-slate-900 px-2 py-0.5 rounded text-[10px] select-all font-mono">{{ url('/whatsapp/webhook') }}</code>
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-sm transition flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Aktifkan Bot Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TOAST -->
<div id="toastContainer" class="fixed top-4 right-4 z-[100] space-y-2 pointer-events-none"></div>

<!-- ==================== STYLES ==================== -->
<style>
    .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }
    .dark .custom-scroll::-webkit-scrollbar-thumb { background: #475569; }

    @keyframes typingBounce {
        0%, 60%, 100% { opacity: 0.3; transform: translateY(0); }
        30% { opacity: 1; transform: translateY(-4px); }
    }
    .typing-dot { animation: typingBounce 1.4s infinite; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes pulseGreen {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
        50% { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
    }
    .pulse-green { animation: pulseGreen 2s infinite; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .slide-up { animation: slideUp 0.3s ease-out; }

    @keyframes msgAppear {
        from { opacity: 0; transform: translateY(8px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .msg-appear { animation: msgAppear 0.25s ease-out; }

    @keyframes toastIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }
    .toast-in { animation: toastIn 0.35s ease-out; }
    .toast-out { animation: toastOut 0.3s ease-in forwards; }

    .bubble-in { border-radius: 4px 16px 16px 16px; }
    .bubble-out { border-radius: 16px 4px 16px 16px; }

    #sidebarWrap { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    @media (min-width: 1024px) {
        #sidebarWrap { width: 320px; }
        #sidebarWrap.sidebar-closed { width: 0; }
    }
    @media (max-width: 1023px) {
        #sidebarWrap {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: 320px; max-width: 85vw; z-index: 25;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
        }
        #sidebarWrap.sidebar-open {
            transform: translateX(0);
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }
    }

    #toolsPanelWrap { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    @media (min-width: 1280px) {
        #toolsPanelWrap { width: 340px; }
        #toolsPanelWrap.panel-closed { width: 0; }
    }
    @media (max-width: 1279px) {
        #toolsPanelWrap {
            position: fixed; top: 0; right: 0; bottom: 0;
            width: 340px; max-width: 90vw; z-index: 25;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
        }
        #toolsPanelWrap.panel-open {
            transform: translateX(0);
            box-shadow: -4px 0 24px rgba(0,0,0,0.15);
        }
    }

    #openSidebarBtn, #openToolsBtn {
        opacity: 0; pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    #openSidebarBtn.visible, #openToolsBtn.visible {
        opacity: 1; pointer-events: auto;
    }
    #openSidebarBtn.visible:hover { transform: translateY(-50%) scale(1.05); }
    #openToolsBtn.visible:hover { transform: translateY(-50%) scale(1.05); }
</style>

<!-- ==================== SCRIPTS ==================== -->
<script>
// ===== DATA DARI LARAVEL (variabel sederhana dari @php block) =====
const contacts = @json($contactsJson);
const chatData = @json($chatDataJson);

let botActive = {{ isset($bot) && $bot->is_active ? 'true' : 'false' }};
let activeContact = contacts.length > 0 ? contacts[0].id : null;

let trainingData = [
    { q: 'Masih ready?', a: 'Produk masih ready kak. Silakan order!', cat: 'Produk' },
    { q: 'Berapa harga?', a: 'Harga mulai dari Rp 89.000 - Rp 250.000 tergantung model.', cat: 'Harga' },
    { q: 'Bisa COD?', a: 'Bisa COD kak, khusus area Jabodetabek.', cat: 'Pengiriman' },
];
let knowledgeData = [
    { title: 'Kemeja Flanel Premium', content: 'Harga Rp 189.000. Tersedia: Hitam, Navy, Abu. Size M/L/XL. Bahan cotton premium.', category: 'Produk' },
];
let autoReplyRules = [
    { keyword: 'ready', reply: 'Produk masih ready kak! Langsung order ya 🛒', active: true },
    { keyword: 'harga', reply: 'Harga mulai dari Rp 89.000 kak.', active: true },
];

let contactFilter = 'all';
let sidebarOpen = window.innerWidth >= 1024;
let toolsPanelOpen = window.innerWidth >= 1280;

// ===== CSRF TOKEN =====
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

// ===== TOAST =====
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const colors = {
        success: 'bg-emerald-600', error: 'bg-red-600',
        info: 'bg-blue-600', warning: 'bg-amber-600'
    };
    const icons = {
        success: '✓', error: '✕', info: 'ℹ', warning: '⚠'
    };
    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-2.5 px-4 py-3 rounded-xl text-white text-sm font-medium shadow-xl toast-in ${colors[type] || colors.info}`;
    toast.innerHTML = `<span class="text-base">${icons[type] || icons.info}</span><span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.remove('toast-in');
        toast.classList.add('toast-out');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ===== DARK MODE =====
function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
}
if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
}

// ===== SIDEBAR =====
function toggleSidebar() {
    sidebarOpen = !sidebarOpen;
    updateSidebar();
}

function updateSidebar() {
    const w = document.getElementById('sidebarWrap');
    const o = document.getElementById('sidebarOverlay');
    const b = document.getElementById('openSidebarBtn');

    if (window.innerWidth >= 1024) {
        w.classList.toggle('sidebar-closed', !sidebarOpen);
        w.classList.remove('sidebar-open');
        o.style.opacity = '0';
        o.style.pointerEvents = 'none';
        if (b) b.classList.toggle('visible', !sidebarOpen);
    } else {
        w.classList.remove('sidebar-closed');
        w.classList.toggle('sidebar-open', sidebarOpen);
        o.style.opacity = sidebarOpen ? '1' : '0';
        o.style.pointerEvents = sidebarOpen ? 'auto' : 'none';
        if (b) b.classList.remove('visible');
    }
}

// ===== TOOLS PANEL =====
function toggleToolsPanel() {
    toolsPanelOpen = !toolsPanelOpen;
    updateToolsPanel();
}

function updateToolsPanel() {
    const w = document.getElementById('toolsPanelWrap');
    const o = document.getElementById('toolsPanelOverlay');
    const b = document.getElementById('openToolsBtn');

    if (window.innerWidth >= 1280) {
        w.classList.toggle('panel-closed', !toolsPanelOpen);
        w.classList.remove('panel-open');
        o.style.opacity = '0';
        o.style.pointerEvents = 'none';
        if (b) b.classList.toggle('visible', !toolsPanelOpen);
    } else {
        w.classList.remove('panel-closed');
        w.classList.toggle('panel-open', toolsPanelOpen);
        o.style.opacity = toolsPanelOpen ? '1' : '0';
        o.style.pointerEvents = toolsPanelOpen ? 'auto' : 'none';
        if (b) b.classList.remove('visible');
    }
}

// ===== RESPONSIVE =====
let prevW = window.innerWidth;
window.addEventListener('resize', () => {
    const w = window.innerWidth;
    if ((prevW < 1024 && w >= 1024) || (prevW >= 1024 && w < 1024)) {
        sidebarOpen = w >= 1024;
        updateSidebar();
    }
    if ((prevW < 1280 && w >= 1280) || (prevW >= 1280 && w < 1280)) {
        toolsPanelOpen = w >= 1280;
        updateToolsPanel();
    }
    prevW = w;
});

// ===== CONTACTS & CHAT =====
function renderContacts() {
    const list = document.getElementById('contactList');
    const search = (document.getElementById('searchContacts')?.value || '').toLowerCase();

    let filtered = contacts.filter(c => {
        if (search && !c.name.toLowerCase().includes(search) && !c.lastMsg.toLowerCase().includes(search)) return false;
        if (contactFilter === 'unread' && !(c.unread > 0)) return false;
        if (contactFilter === 'bot' && !c.bot) return false;
        return true;
    });

    if (filtered.length === 0) {
        list.innerHTML = '<div class="p-6 text-center text-xs text-gray-400 dark:text-slate-500">Tidak ada kontak ditemukan</div>';
        return;
    }

    list.innerHTML = filtered.map(c => `
        <div onclick="selectContact('${c.id}')" class="flex items-center gap-3 px-3 py-3 cursor-pointer transition hover:bg-gray-50 dark:hover:bg-slate-700/50 ${activeContact === c.id ? 'bg-emerald-50 dark:bg-emerald-900/20 border-r-2 border-emerald-500' : ''}">
            <div class="relative shrink-0">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br ${c.color} flex items-center justify-center text-white font-bold text-xs">${c.avatar}</div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-sm text-gray-900 dark:text-white truncate">${c.name}</span>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500 shrink-0 ml-2">${c.time}</span>
                </div>
                <div class="flex justify-between items-center mt-0.5">
                    <p class="text-xs text-gray-500 dark:text-slate-400 truncate">${c.bot ? '🤖 ' : ''}${c.lastMsg}</p>
                    ${c.unread > 0 ? `<span class="shrink-0 ml-2 w-5 h-5 bg-emerald-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">${c.unread}</span>` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function selectContact(id) {
    activeContact = id;
    const c = contacts.find(x => x.id === id);
    if (!c) return;

    c.unread = 0;

    document.getElementById('chatAvatar').textContent = c.avatar;
    document.getElementById('chatAvatar').className = `w-10 h-10 rounded-full bg-gradient-to-br ${c.color} flex items-center justify-center text-white font-bold text-sm`;
    document.getElementById('chatName').textContent = c.name;
    document.getElementById('chatStatus').textContent = c.online ? 'Online' : 'Terakhir dilihat ' + c.time;
    document.getElementById('chatOnlineDot').className = c.online
        ? 'absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-slate-800 rounded-full'
        : 'absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-gray-400 border-2 border-white dark:border-slate-800 rounded-full';

    renderContacts();
    renderChat();

    if (window.innerWidth < 1024) {
        sidebarOpen = false;
        updateSidebar();
    }
}

function renderChat() {
    const container = document.getElementById('chatMessages');

    if (!activeContact) {
        container.innerHTML = `
            <div class="flex-1 flex flex-col items-center justify-center text-center p-8 h-full">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-4xl">💬</div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200 mb-2">Larislo WhatsApp Bot</h3>
                <p class="text-gray-500 dark:text-slate-400 text-sm mb-6">Klik kontak di kiri untuk melihat percakapan atau kirim pesan manual.</p>
            </div>`;
        return;
    }

    const messages = chatData[activeContact] || [];

    if (messages.length === 0) {
        container.innerHTML = `
            <div class="flex-1 flex flex-col items-center justify-center text-center p-8 h-full">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-2xl">📝</div>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Belum ada pesan. Mulai percakapan!</p>
            </div>`;
        return;
    }

    container.innerHTML = messages.map(m => {
        if (m.type === 'date') {
            return `<div class="flex justify-center"><span class="text-[10px] bg-white/70 dark:bg-slate-700/70 backdrop-blur px-3 py-1 rounded-full text-gray-500 dark:text-slate-400">${m.text}</span></div>`;
        }
        if (m.type === 'in') {
            const avatar = contacts.find(x => x.id === activeContact)?.avatar || '??';
            return `
                <div class="flex gap-2 max-w-[85%] msg-appear">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 dark:from-slate-600 dark:to-slate-500 shrink-0 mt-1 flex items-center justify-center text-white text-[9px] font-bold">${avatar}</div>
                    <div>
                        <div class="bg-white dark:bg-slate-700 p-3 shadow-sm bubble-in">
                            <p class="text-sm text-gray-800 dark:text-slate-200 leading-relaxed">${m.text}</p>
                        </div>
                        <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-0.5 ml-1 block">${m.time}</span>
                    </div>
                </div>`;
        }
        return `
            <div class="flex gap-2 max-w-[85%] ml-auto msg-appear">
                <div>
                    <div class="bg-emerald-100 dark:bg-emerald-900/40 p-3 shadow-sm bubble-out">
                        <p class="text-sm text-gray-800 dark:text-emerald-100 leading-relaxed">${m.text}</p>
                    </div>
                    <div class="flex items-center justify-end gap-1 mt-0.5 mr-1">
                        ${m.bot ? '<span class="text-[9px] bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 px-1.5 py-0.5 rounded font-medium">AI</span>' : ''}
                        <span class="text-[10px] text-gray-400 dark:text-slate-500">${m.time}</span>
                    </div>
                </div>
            </div>`;
    }).join('');

    container.scrollTop = container.scrollHeight;
}

function filterContacts() {
    renderContacts();
}

function setContactFilter(filter) {
    contactFilter = filter;
    document.querySelectorAll('.contact-filter-btn').forEach(btn => {
        const isActive = btn.dataset.filter === filter;
        if (isActive) {
            btn.classList.add('bg-emerald-100', 'dark:bg-emerald-900/40', 'text-emerald-700', 'dark:text-emerald-300');
            btn.classList.remove('bg-gray-100', 'dark:bg-slate-700', 'text-gray-500', 'dark:text-slate-400');
        } else {
            btn.classList.remove('bg-emerald-100', 'dark:bg-emerald-900/40', 'text-emerald-700', 'dark:text-emerald-300');
            btn.classList.add('bg-gray-100', 'dark:bg-slate-700', 'text-gray-500', 'dark:text-slate-400');
        }
    });
    renderContacts();
}

// ===== SEND MESSAGE =====
function sendMessage() {
    const input = document.getElementById('messageInput');
    const text = input.value.trim();
    if (!text || !activeContact) return;

    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

    if (!chatData[activeContact]) chatData[activeContact] = [];
    chatData[activeContact].push({ type: 'out', text, time, bot: false });

    const contact = contacts.find(c => c.id === activeContact);
    if (contact) {
        contact.lastMsg = text;
        contact.time = time;
    }

    input.value = '';
    renderChat();
    renderContacts();

    fetch('{{ route("whatsapp.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ phone: activeContact, message: text })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('Pesan terkirim!', 'success');
            if (document.getElementById('aiAssistToggle')?.checked) {
                showTypingIndicator();
            }
        } else {
            showToast(data.message || 'Gagal mengirim pesan', 'error');
        }
    })
    .catch(err => {
        showToast('Error koneksi ke server', 'error');
    });
}

function sendQuickReply(text) {
    document.getElementById('messageInput').value = text;
    sendMessage();
}

function showTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    indicator.classList.remove('hidden');

    setTimeout(() => {
        indicator.classList.add('hidden');

        const lastMsg = chatData[activeContact]?.filter(m => m.type === 'out').pop()?.text?.toLowerCase() || '';

        let botReply = null;
        for (const rule of autoReplyRules) {
            if (rule.active && lastMsg.includes(rule.keyword)) {
                botReply = rule.reply;
                break;
            }
        }

        if (!botReply && document.getElementById('aiAssistToggle')?.checked) {
            const replies = [
                'Terima kasih sudah menghubungi kami! Tim kami akan segera membalas. 😊',
                'Halo kak! Ada yang bisa kami bantu? 🛍️',
                'Baik kak, pesan Anda sudah kami terima. Mohon tunggu sebentar ya!',
            ];
            botReply = replies[Math.floor(Math.random() * replies.length)];
        }

        if (botReply) {
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            if (!chatData[activeContact]) chatData[activeContact] = [];
            chatData[activeContact].push({ type: 'in', text: botReply, time });

            renderChat();

            const contact = contacts.find(c => c.id === activeContact);
            if (contact) {
                contact.lastMsg = '🤖 ' + botReply;
                contact.time = time;
                renderContacts();
            }
        }
    }, 1500 + Math.random() * 1000);
}

// ===== TOGGLE BOT =====
function toggleBot() {
    if (!botActive) {
        openActivateModal();
        return;
    }

    botActive = !botActive;

    const dot = document.getElementById('botStatusDot');
    const text = document.getElementById('botStatusText');
    const icon = document.getElementById('botToggleIcon');
    const label = document.getElementById('botToggleLabel');

    if (botActive) {
        dot.className = 'w-2 h-2 rounded-full bg-green-300 pulse-green';
        text.textContent = 'Active';
        text.className = 'text-xs text-emerald-100';
        icon.textContent = '🤖';
        label.textContent = 'Bot On';
        showToast('Bot diaktifkan', 'success');
    } else {
        dot.className = 'w-2 h-2 rounded-full bg-amber-300';
        text.textContent = 'Paused';
        text.className = 'text-xs text-amber-100';
        icon.textContent = '⏸️';
        label.textContent = 'Bot Off';
        showToast('Bot dijeda', 'warning');
    }
}

// ===== ACTIVATE MODAL =====
function openActivateModal() {
    document.getElementById('activateBotModal').classList.remove('hidden');
}

function closeActivateModal() {
    document.getElementById('activateBotModal').classList.add('hidden');
}

// ===== TOOL TABS =====
function setToolTab(tab) {
    document.querySelectorAll('.tool-tab').forEach(btn => {
        const isActive = btn.dataset.tab === tab;
        if (isActive) {
            btn.classList.add('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
            btn.classList.remove('border-transparent', 'text-gray-400', 'dark:text-slate-500');
        } else {
            btn.classList.remove('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
            btn.classList.add('border-transparent', 'text-gray-400', 'dark:text-slate-500');
        }
    });
    document.querySelectorAll('.tool-tab-content').forEach(el => el.classList.add('hidden'));
    const target = document.getElementById('tab-' + tab);
    if (target) target.classList.remove('hidden');
}

// ===== TRAINING =====
function startTraining(event) {
    event.preventDefault();

    const progress = document.getElementById('trainingProgress');
    const bar = document.getElementById('trainingBar');
    const percent = document.getElementById('trainingPercent');
    const status = document.getElementById('trainingStatus');

    progress.classList.remove('hidden');

    const steps = [
        { p: 15, s: 'Menganalisis data produk...' },
        { p: 35, s: 'Membangun model AI...' },
        { p: 55, s: 'Melatih respons bot...' },
        { p: 75, s: 'Mengoptimasi akurasi...' },
        { p: 90, s: 'Finalisasi model...' },
        { p: 100, s: 'Training selesai! 🎉' },
    ];

    let i = 0;
    const interval = setInterval(() => {
        if (i < steps.length) {
            bar.style.width = steps[i].p + '%';
            percent.textContent = steps[i].p + '%';
            status.textContent = steps[i].s;
            i++;
        } else {
            clearInterval(interval);
            showToast('Training AI berhasil!', 'success');
            setTimeout(() => progress.classList.add('hidden'), 2000);
        }
    }, 800);
}

function addTrainingData() {
    const q = document.getElementById('trainQuestion').value.trim();
    const a = document.getElementById('trainAnswer').value.trim();
    const cat = document.getElementById('trainCategory').value;

    if (!q || !a) {
        showToast('Pertanyaan dan jawaban wajib diisi', 'warning');
        return;
    }

    trainingData.unshift({ q, a, cat });
    document.getElementById('trainQuestion').value = '';
    document.getElementById('trainAnswer').value = '';
    renderTrainingData();
    showToast('Data training ditambahkan!', 'success');
}

function renderTrainingData() {
    const list = document.getElementById('trainingDataList');
    const countEl = document.getElementById('trainingCount');
    if (countEl) countEl.textContent = trainingData.length;

    list.innerHTML = trainingData.slice(0, 10).map((item, i) => `
        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-2.5 group relative">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-700 dark:text-slate-300 truncate">Q: ${item.q}</p>
                    <p class="text-[10px] text-gray-500 dark:text-slate-400 truncate">A: ${item.a}</p>
                </div>
                <span class="shrink-0 text-[9px] px-1.5 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded capitalize">${item.cat}</span>
            </div>
            <button onclick="removeTrainingData(${i})" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 p-0.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded transition">
                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

function removeTrainingData(index) {
    trainingData.splice(index, 1);
    renderTrainingData();
    showToast('Data training dihapus', 'info');
}

// ===== KNOWLEDGE =====
function addKnowledge() {
    const title = document.getElementById('kbTitle').value.trim();
    const content = document.getElementById('kbContent').value.trim();

    if (!title || !content) {
        showToast('Judul dan konten wajib diisi', 'warning');
        return;
    }

    knowledgeData.unshift({ title, content, category: 'Produk' });
    document.getElementById('kbTitle').value = '';
    document.getElementById('kbContent').value = '';
    renderKnowledge();
    showToast('Pengetahuan ditambahkan!', 'success');
}

function renderKnowledge() {
    const list = document.getElementById('knowledgeList');
    list.innerHTML = knowledgeData.map((item, i) => `
        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-2.5 group relative">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-700 dark:text-slate-300">📚 ${item.title}</p>
                    <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-0.5 line-clamp-2">${item.content}</p>
                </div>
            </div>
            <button onclick="removeKnowledge(${i})" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 p-0.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded transition">
                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

function removeKnowledge(index) {
    knowledgeData.splice(index, 1);
    renderKnowledge();
    showToast('Pengetahuan dihapus', 'info');
}

// ===== AUTO-REPLY =====
function addAutoReply() {
    const keyword = document.getElementById('arKeyword').value.trim();
    const reply = document.getElementById('arReply').value.trim();

    if (!keyword || !reply) {
        showToast('Keyword dan balasan wajib diisi', 'warning');
        return;
    }

    autoReplyRules.unshift({ keyword, reply, active: true });
    document.getElementById('arKeyword').value = '';
    document.getElementById('arReply').value = '';
    renderAutoReply();
    showToast('Aturan auto-reply ditambahkan!', 'success');
}

function renderAutoReply() {
    const list = document.getElementById('autoReplyList');
    list.innerHTML = autoReplyRules.map((item, i) => `
        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-2.5 group relative">
            <div class="flex items-center justify-between gap-2 mb-1">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono px-1.5 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded">"${item.keyword}"</span>
                    <button onclick="toggleAutoReply(${i})" class="text-[10px] px-1.5 py-0.5 rounded ${item.active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-gray-200 dark:bg-slate-600 text-gray-400 dark:text-slate-500'}">${item.active ? 'Aktif' : 'Nonaktif'}</button>
                </div>
            </div>
            <p class="text-[10px] text-gray-500 dark:text-slate-400">→ ${item.reply}</p>
            <button onclick="removeAutoReply(${i})" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 p-0.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded transition">
                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
}

function toggleAutoReply(index) {
    autoReplyRules[index].active = !autoReplyRules[index].active;
    renderAutoReply();
}

function removeAutoReply(index) {
    autoReplyRules.splice(index, 1);
    renderAutoReply();
    showToast('Aturan dihapus', 'info');
}

// ===== CLOSE MODAL (generic) =====
function closeModal(id) {
    document.getElementById(id)?.classList.add('hidden');
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', () => {
    updateSidebar();
    updateToolsPanel();
    renderContacts();
    renderChat();
    renderTrainingData();
    renderKnowledge();
    renderAutoReply();

    // Cek apakah bot sudah di-setup atau belum
    let isConfigured = {{ isset($bot) && $bot->is_configured ? 'true' : 'false' }};

    if (!isConfigured) {
        // Jika belum setup, langsung buka modal koneksi WA
        openActivateModal();

        // Ubah status header jadi "Not Connected"
        document.getElementById('botStatusText').textContent = 'Not Connected';
        document.getElementById('botStatusDot').classList.remove('bg-green-300', 'pulse-green');
        document.getElementById('botStatusDot').classList.add('bg-red-400');
        document.getElementById('botToggleIcon').textContent = '⚙️';
        document.getElementById('botToggleLabel').textContent = 'Setup';
    } else if (!botActive) {
        // Jika sudah setup tapi bot di-pause
        document.getElementById('botStatusText').textContent = 'Paused';
        document.getElementById('botStatusDot').classList.remove('bg-green-300', 'pulse-green');
        document.getElementById('botStatusDot').classList.add('bg-amber-400');
        document.getElementById('botToggleIcon').textContent = '⏸️';
        document.getElementById('botToggleLabel').textContent = 'Bot Off';
    }

    if (activeContact) {
        selectContact(activeContact);
    }
});

function toggleApiKeyVisibility() {
    const input = document.getElementById('apiKeyInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}
</script>
@endsection
