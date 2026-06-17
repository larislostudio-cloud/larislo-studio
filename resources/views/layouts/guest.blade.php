<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LARISLO') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Prevent FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <!-- Container Utama -->
    <div x-data="guestLayout()" class="min-h-screen flex flex-col lg:flex-row">

        <!-- ================= SISI KIRI: Branding ================= -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-sky-600 to-blue-900 relative overflow-hidden justify-center items-center p-12">

            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <div class="relative z-10 text-center text-white max-w-md">
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight">LARISLO</h1>
                <p class="text-xl opacity-90 mb-10 leading-relaxed">Platform AI Marketing No. 1 untuk UMKM di Indonesia.</p>

                <div class="mb-10">
                    <i class="fas fa-rocket text-7xl opacity-80 transform hover:rotate-12 transition-transform duration-300"></i>
                </div>

                <div class="text-left space-y-4 text-sm">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                        <span>Generate Caption & Gambar dengan AI</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                        <span>Auto Posting ke Semua Sosmed</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                        <span>Tingkatkan Penjualan Otomatis</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SISI KANAN: Area Form ================= -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 md:p-10 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300 relative">

            <!-- Dark Mode Toggle -->
            <div class="absolute top-4 right-4">
                <button @click="toggleDarkMode()" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 shadow-sm border border-slate-200 dark:border-slate-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-sky-500" :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                    <svg x-show="darkMode" x-transition class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!darkMode" x-transition class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>

            <div class="w-full max-w-md space-y-6">

                <!-- Logo untuk Mobile -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-3xl font-bold text-sky-600 dark:text-sky-400">LARISLO</h1>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">AI Marketing Platform</p>
                </div>

                <!-- Flash Message -->
                @if (session('status'))
                    <div class="text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-200 dark:border-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Slot untuk Konten Login/Register -->
                {{ $slot }}

            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function guestLayout() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

                init() {
                    this.applyTheme();
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
