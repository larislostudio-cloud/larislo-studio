<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LARISLO') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Prevent FOUC: Terapkan dark class SEBELUM render -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <!-- Main Container -->
    <div x-data="layoutState()" class="flex h-screen overflow-hidden">

        <!-- ===================== MOBILE SIDEBAR OVERLAY ===================== -->
        <!-- Muncul hanya di mobile saat sidebar terbuka -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- ===================== SIDEBAR ===================== -->
        <!-- DIHAPUS: lg:translate-x-0. Sekedar sidebar mengikuti state sidebarOpen sepenuhnya -->
        <aside x-show="sidebarOpen"
               x-transition:enter="transition transform duration-300 ease-in-out"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition transform duration-300 ease-in-out"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 dark:bg-slate-950 text-white border-r border-slate-800 dark:border-slate-800 flex flex-col">

            <!-- Logo Section -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800 dark:border-slate-800 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-tr from-sky-400 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xs">L</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LARISLO</span>
                </a>
                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    Dashboard
                </x-nav-link>

                <!-- ===================== ADMIN PANEL ===================== -->
                @can('access-admin')
                    <div class="pt-4">
                        <span class="px-3 text-xs font-bold text-slate-500 dark:text-slate-600 uppercase tracking-wider">Admin Panel</span>
                    </div>
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        Admin Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('admin.transactions.index')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        Validasi Pembayaran
                    </x-nav-link>
                @endcan
                <!-- ===================== END ADMIN PANEL ===================== -->

                <div class="pt-4">
                    <span class="px-3 text-xs font-bold text-slate-500 dark:text-slate-600 uppercase tracking-wider">AI Tools</span>
                </div>
                <x-nav-link :href="route('ai.caption.index')" :active="request()->routeIs('ai.caption.*')" icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    AI Caption
                </x-nav-link>
                <x-nav-link :href="route('ai.image.index')" :active="request()->routeIs('ai.image.*')" icon="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    AI Image
                </x-nav-link>
                <x-nav-link :href="route('ai.video.index')" :active="request()->routeIs('ai.video.*')" icon="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    AI Video
                </x-nav-link>

                <div class="pt-4">
                    <span class="px-3 text-xs font-bold text-slate-500 dark:text-slate-600 uppercase tracking-wider">Marketing</span>
                </div>
                <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    Planner
                </x-nav-link>
                <x-nav-link :href="route('social.scheduler.create')" :active="request()->routeIs('social.scheduler.*')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    Scheduler
                </x-nav-link>
                <x-nav-link :href="route('whatsapp.index')" :active="request()->routeIs('whatsapp.*')" icon="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    WhatsApp AI
                </x-nav-link>
                <x-nav-link :href="route('affiliate.index')" :active="request()->routeIs('affiliate.*')" icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    Affiliate
                </x-nav-link>

                <div class="pt-4">
                    <span class="px-3 text-xs font-bold text-slate-500 dark:text-slate-600 uppercase tracking-wider">System</span>
                </div>
                <x-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')" icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    Analytics
                </x-nav-link>
                <x-nav-link :href="route('marketplace.index')" :active="request()->routeIs('marketplace.*')" icon="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    Marketplace
                </x-nav-link>
            </nav>

            <!-- Bottom User Info -->
            <div class="border-t border-slate-800 dark:border-slate-800 p-4 shrink-0">
                 <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sky-500 rounded-full flex items-center justify-center font-bold text-white shrink-0">
                        {{ strtoupper(auth()->user()->name[0]) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500">💎 {{ auth()->user()->credits ?? 0 }} Kredit</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 transition shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                 </div>
            </div>
        </aside>

        <!-- ===================== CONTENT AREA ===================== -->
        <!-- DITAMBAHKAN: transition-all agar pergeseran margin smooth saat sidebar dibuka/ditutup -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'">

            <!-- Top Navbar -->
            <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-30 transition-colors duration-300">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                    <!-- Left: Toggle & Title -->
                    <div class="flex items-center gap-4">
                        <!-- DIHAPUS: lg:hidden. Tombol ini sekarang selalu tampil agar bisa toggle di desktop -->
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 focus:outline-none p-1 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-200 hidden sm:block">@yield('title', 'Dashboard')</h1>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Dark Mode Toggle -->
                        <button @click="toggleDarkMode()" class="relative w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-700 dark:hover:text-slate-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-sky-500" :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                            <!-- Sun Icon -->
                            <svg x-show="darkMode" x-transition class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <!-- Moon Icon -->
                            <svg x-show="!darkMode" x-transition class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>

                        <!-- Credit Badge -->
                        <a href="{{ route('billing.index') }}" class="flex items-center gap-1 bg-sky-50 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400 px-3 py-1.5 rounded-full text-sm font-semibold hover:bg-sky-100 dark:hover:bg-sky-900/50 transition">
                            <span>💎</span> <span>{{ auth()->user()->credits ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 px-4 py-3 rounded-lg flex justify-between items-center">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                        <button @click="show = false" class="text-green-700 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 px-4 py-3 rounded-lg flex justify-between items-center">
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                        <button @click="show = false" class="text-red-700 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">&times;</button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function layoutState() {
            return {
                sidebarOpen: window.innerWidth >= 1024,
                darkMode: localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

                init() {
                    this.applyTheme();

                    // Opsional: Tutup sidebar secara default jika tiba-tiba di-resize ke mobile
                    window.addEventListener('resize', () => {
                        if (window.innerWidth < 1024 && this.sidebarOpen) {
                            this.sidebarOpen = false;
                        }
                    });
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    this.applyTheme();
                },

                applyTheme() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                }
            }
        }
    </script>
</body>
</html>
