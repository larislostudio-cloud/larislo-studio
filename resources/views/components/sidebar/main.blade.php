<!--
    Kita inisialisasi state 'sidebarOpen' berdasarkan lebar layar.
    Jika layar >= 1024px (lg), sidebarOpen = true (terbuka).
    Jika layar < 1024px, sidebarOpen = false (tertutup).
-->
<div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-gray-100 dark:bg-slate-900 transition-colors duration-300">

    <!-- Overlay untuk Mobile (Background gelap) -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden">
    </div>

    <!-- SIDEBAR UTAMA -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed left-0 top-0 z-40 h-screen w-64 bg-gray-900 dark:bg-slate-950 text-white pt-4 transition-transform duration-300 ease-in-out transform border-r border-gray-800 dark:border-slate-800">

        <!-- Header Logo (Dengan Gambar) -->
        <div class="px-4 mb-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <!-- Logo untuk Light Mode (Sidebar terang) - Jika sidebar selalu gelap, ini disembunyikan -->
                <img src="{{ asset('images/logo4.png') }}" alt="Larislo Logo" class="h-9 w-9 rounded-xl block dark:hidden transition-transform group-hover:scale-105">
                <!-- Logo untuk Dark Mode (Sidebar gelap) -->
                <img src="{{ asset('images/logo4.png') }}" alt="Larislo Logo" class="h-9 w-9 rounded-xl hidden dark:block transition-transform group-hover:scale-105">

                <div>
                    <h1 class="text-2xl font-bold text-sky-400 tracking-tight">LARISLO</h1>
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">AI Marketing Platform</span>
                </div>
            </a>
            <!-- Tombol Close (X) - Hanya muncul di mobile -->
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="px-2 space-y-1">
            <!-- Dashboard -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                📊 Dashboard
            </x-nav-link>

            <!-- AI Section -->
            <div class="px-3 text-xs text-gray-500 uppercase pt-4">AI Tools</div>

            <x-nav-link :href="route('ai.caption.index')" :active="request()->routeIs('ai.caption.*')">
                ✍️ AI Caption
            </x-nav-link>

            <x-nav-link :href="route('ai.video.index')" :active="request()->routeIs('ai.video.*')">
                🎬 AI Video
            </x-nav-link>

            <x-nav-link :href="route('ai.image.index')" :active="request()->routeIs('ai.image.*')">
                🖼️ AI Image
            </x-nav-link>

            <!-- Marketing Section -->
            <div class="px-3 text-xs text-gray-500 uppercase pt-4">Marketing</div>

            <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')">
                📅 Content Planner
            </x-nav-link>

            <x-nav-link :href="route('social.scheduler.create')" :active="request()->routeIs('social.scheduler.*')">
                🚀 Social Scheduler
            </x-nav-link>

            <x-nav-link :href="route('whatsapp.index')" :active="request()->routeIs('whatsapp.*')">
                💬 WhatsApp AI
            </x-nav-link>

            <x-nav-link :href="route('affiliate.index')" :active="request()->routeIs('affiliate.*')">
                💰 Affiliate Tools
            </x-nav-link>

            <!-- System Section -->
            <div class="px-3 text-xs text-gray-500 uppercase pt-4">System</div>

            <!-- MENU KREDIT BARU (Disesuaikan di sini) -->
            <x-nav-link :href="route('billing.index')" :active="request()->routeIs('billing.*')">
                <span class="flex items-center gap-2">
                    💎 <span>Kredit ({{ auth()->user()->credits ?? 0 }})</span>
                </span>
            </x-nav-link>

            <x-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')">
                📈 Analytics
            </x-nav-link>

            <x-nav-link :href="route('marketplace.index')" :active="request()->routeIs('marketplace.*')">
                🛒 Marketplace
            </x-nav-link>

            <x-nav-link href="#" :active="request()->routeIs('settings.*')">
                ⚙️ Settings
            </x-nav-link>
        </nav>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out"
         :class="sidebarOpen ? 'lg:ml-64' : ''">

        <!-- TOP NAVBAR -->
        <header class="bg-white dark:bg-slate-800 shadow-sm h-16 flex items-center px-4 lg:px-8 z-10 transition-colors duration-300">
            <!-- Tombol Hamburger / Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-slate-400 focus:outline-none hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Judul Halaman -->
            <div class="ml-4 text-xl font-semibold text-gray-800 dark:text-white transition-colors duration-300">
                @yield('title', 'LARISLO')
            </div>

            <!-- User menu di kanan -->
            <div class="ml-auto flex items-center gap-4">
                <span class="text-gray-700 dark:text-slate-300 text-sm font-medium hidden sm:block transition-colors duration-300">{{ auth()->user()->name }}</span>

                <!-- Dropdown Menu Sederhana -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-gray-600 dark:text-slate-400 hover:text-gray-800 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 z-20 border border-gray-100 dark:border-slate-700 transition-colors duration-300">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Konten Halaman -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-gray-50 dark:bg-slate-900 transition-colors duration-300">
            {{ $slot }}
        </main>
    </div>
</div>
