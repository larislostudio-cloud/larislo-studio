<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LARISLO - AI Marketing Platform untuk UMKM</title>
    <meta name="description" content="Tingkatkan penjualan UMKM dengan AI Marketing Platform.">

    @vite(['resources/css/app.css'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Prevent FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        }

        .glow-blue {
            box-shadow: 0 0 40px -10px rgba(37, 99, 235, 0.5);
        }

        .card-glow:hover {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(14, 165, 233, 0.2);
            transform: translateY(-5px);
        }

        .dark .card-glow:hover {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(14, 165, 233, 0.3);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .hero-shape-1 {
            position: absolute;
            top: 10%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(14,165,233,0.2) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            filter: blur(40px);
            animation: pulse-glow 8s infinite;
        }
        .hero-shape-2 {
            position: absolute;
            bottom: 10%;
            right: 5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            filter: blur(50px);
            animation: pulse-glow 10s infinite reverse;
        }

        .grid-bg {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
        }

        .dark .grid-bg {
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
    </style>
</head>
<body class="text-slate-800 dark:text-slate-100 antialiased bg-slate-50 dark:bg-slate-950 transition-colors duration-300">

    <!-- ===================== NAVBAR ===================== -->
    <nav x-data="landingLayout()" id="navbar" class="fixed w-full z-50 transition-all duration-300 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="glass rounded-full shadow-sm px-6 py-3 flex justify-between items-center">

                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo4.png') }}" alt="Larislo Logo" class="h-9 w-9 rounded-xl block dark:hidden">
                    <img src="{{ asset('images/logo4.png') }}" alt="Larislo Logo" class="h-9 w-9 rounded-xl hidden dark:block">
                    <span class="text-xl font-black text-slate-900 dark:text-white tracking-tight">LARISLO</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Fitur</a>
                    <a href="#pricing" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Harga</a>
                    <a href="#payments" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Pembayaran</a>
                    <a href="#faq" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">FAQ</a>
                </div>

                <!-- CTA, Dark Mode & Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <button @click="toggleDarkMode()" class="w-9 h-9 rounded-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300 focus:outline-none" :title="darkMode ? 'Light Mode' : 'Dark Mode'">
                        <svg x-show="darkMode" x-transition class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="!darkMode" x-transition class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors px-4 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="hidden sm:block gradient-bg text-white text-sm font-bold px-5 py-2.5 rounded-full shadow-lg hover:shadow-sky-200 dark:hover:shadow-sky-900/30 transition-all hover:-translate-y-0.5">Mulai Gratis</a>

                    <button id="nav-toggle" class="md:hidden text-slate-700 dark:text-slate-300 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="nav-menu" class="hidden md:hidden mt-2 glass rounded-2xl p-4 shadow-xl">
                <div class="flex flex-col space-y-2">
                    <a href="#features" class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg font-medium">Fitur</a>
                    <a href="#pricing" class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg font-medium">Harga</a>
                    <a href="#payments" class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg font-medium">Pembayaran</a>
                    <a href="#faq" class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg font-medium">FAQ</a>
                    <hr class="border-slate-200 dark:border-slate-700 my-2">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-center border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium hover:bg-white/50 dark:hover:bg-slate-800/50">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-center gradient-bg text-white rounded-lg font-bold shadow-md">Mulai Gratis</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===================== HERO SECTION ===================== -->
    <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 overflow-hidden grid-bg bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <!-- Hero Shapes & Content (Tetap sama) -->
        <div class="hero-shape-1"></div>
        <div class="hero-shape-2"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left" data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 dark:bg-sky-900/30 border border-sky-100 dark:border-sky-800 mb-6">
                        <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span></span>
                        <span class="text-xs font-bold text-sky-700 dark:text-sky-400 uppercase tracking-wider">Pay-as-you-go System</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight mb-6">Marketing AI untuk UMKM<br><span class="gradient-text">Tanpa Langganan Bulanan.</span></h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">Mulai gratis 3 kredit setiap hari. Beli tambahan kredit hanya saat dibutuhkan. Hemat, fleksibel, dan powerful.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-4 gradient-bg text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:shadow-sky-200 dark:hover:shadow-sky-900/30 transition-all transform hover:-translate-y-1">Mulai Gratis Sekarang <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i></a>
                        <a href="#pricing" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold rounded-2xl shadow hover:shadow-lg border border-slate-200 dark:border-slate-700 transition-all"><i class="fas fa-coins text-sky-600 dark:text-sky-400"></i> Lihat Harga Kredit</a>
                    </div>
                </div>
                <div class="relative" data-aos="fade-left" data-aos-delay="200">
                    <div class="relative w-full bg-gradient-to-br from-sky-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden float-animation">
                        <div class="absolute top-0 left-0 right-0 h-12 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm flex items-center px-4 gap-2 border-b border-slate-100 dark:border-slate-700 z-10">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div><div class="w-3 h-3 rounded-full bg-yellow-400"></div><div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <div class="flex-1 mx-4 h-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center text-[10px] text-slate-400">app.larislo.com</div>
                        </div>
                        <div class="pt-12 bg-slate-100 dark:bg-slate-950">
                            <img src="{{ asset('images/hero.png') }}" alt="Larislo AI Dashboard" class="w-full h-auto object-cover object-top">
                        </div>
                    </div>
                    <div class="absolute -z-10 -top-10 -right-10 w-40 h-40 bg-blue-100 dark:bg-blue-900/30 rounded-full filter blur-2xl opacity-60"></div>
                    <div class="absolute -z-10 -bottom-10 -left-10 w-40 h-40 bg-sky-100 dark:bg-sky-900/30 rounded-full filter blur-2xl opacity-60"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== FEATURES ===================== -->
    <section id="features" class="py-20 relative bg-white dark:bg-slate-900 transition-colors duration-300">
        <!-- Feature Content (Tetap sama) -->
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up"><h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">Satu Platform, Semua Solusi</h2><p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Tools canggih yang dirancang khusus untuk efisiensi bisnis modern.</p></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 transition-all duration-300 card-glow relative overflow-hidden" data-aos="fade-up"><div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-sky-50 dark:from-sky-900/20 to-transparent rounded-bl-full"></div><div class="relative z-10"><div class="w-14 h-14 bg-sky-100 dark:bg-sky-900/50 rounded-2xl flex items-center justify-center mb-6 text-sky-600 dark:text-sky-400 transition-all group-hover:bg-sky-600 group-hover:text-white"><i class="fas fa-wand-magic-sparkles text-2xl"></i></div><h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">AI Caption & Image Generator</h3><p class="text-slate-500 dark:text-slate-400 mb-6 max-w-lg">Buat konten viral dan gambar promosi profesional dalam detik. Didukung oleh teknologi GPT-4 terbaru.</p><div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 flex items-center gap-4 border border-slate-100 dark:border-slate-600"><div class="flex-1 space-y-2"><div class="h-3 w-full bg-slate-200 dark:bg-slate-600 rounded animate-pulse"></div><div class="h-3 w-5/6 bg-sky-200 dark:bg-sky-800 rounded"></div></div><button class="px-4 py-2 bg-sky-600 text-white text-sm font-bold rounded-lg opacity-80 cursor-default">Generate</button></div></div></div>
                <div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 transition-all duration-300 card-glow flex flex-col" data-aos="fade-up" data-aos-delay="100"><div class="w-14 h-14 bg-green-100 dark:bg-green-900/50 rounded-2xl flex items-center justify-center mb-6 text-green-600 dark:text-green-400 transition-all group-hover:bg-green-600 group-hover:text-white"><i class="fab fa-whatsapp text-3xl"></i></div><h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">WhatsApp Bot AI</h3><p class="text-slate-500 dark:text-slate-400 text-sm flex-grow">Balas chat pelanggan 24/7 secara otomatis. Tingkatkan kepuasan pelanggan tanpa menambah staf.</p><div class="mt-6 border-t border-slate-100 dark:border-slate-700 pt-4 flex items-center justify-between text-xs text-slate-400 dark:text-slate-500"><span>Auto-reply Active</span><span class="flex items-center gap-1 text-green-500"><i class="fas fa-circle text-[6px]"></i> Online</span></div></div>
                <div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 transition-all duration-300 card-glow" data-aos="fade-up" data-aos-delay="150"><div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center mb-4 text-purple-600 dark:text-purple-400 transition-all group-hover:bg-purple-600 group-hover:text-white"><i class="fas fa-calendar-check text-xl"></i></div><h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Auto Posting</h3><p class="text-slate-500 dark:text-slate-400 text-sm">Jadwalkan konten ke Instagram, TikTok, & FB.</p></div>
                <div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 transition-all duration-300 card-glow" data-aos="fade-up" data-aos-delay="200"><div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center mb-4 text-amber-600 dark:text-amber-400 transition-all group-hover:bg-amber-600 group-hover:text-white"><i class="fas fa-chart-line text-xl"></i></div><h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Analytics Dashboard</h3><p class="text-slate-500 dark:text-slate-400 text-sm">Pantau pertumbuhan engagement secara real-time.</p></div>
                <div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 transition-all duration-300 card-glow" data-aos="fade-up" data-aos-delay="250"><div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/50 rounded-xl flex items-center justify-center mb-4 text-rose-600 dark:text-rose-400 transition-all group-hover:bg-rose-600 group-hover:text-white"><i class="fas fa-video text-xl"></i></div><h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Video Maker</h3><p class="text-slate-500 dark:text-slate-400 text-sm">Ubah produk menjadi video promosi menarik.</p></div>
            </div>
        </div>
    </section>

    <!-- ===================== PRICING ===================== -->
    <section id="pricing" class="py-20 bg-slate-50 dark:bg-slate-950 relative overflow-hidden transition-colors duration-300">
        <!-- Pricing Content (Tetap sama) -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up"><span class="text-sky-600 dark:text-sky-400 font-bold text-sm uppercase tracking-wider">Top Up Kredit</span><h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mt-3 mb-4">Investasi Fleksibel</h2><p class="text-slate-500 dark:text-slate-400">Beli sekali, pakai selamanya. Tidak ada kadaluarsa.</p></div>
            <div class="grid md:grid-cols-3 gap-8 items-start">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-8 transition-all duration-300 hover:border-sky-200 dark:hover:border-sky-700 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100"><div class="mb-6"><h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Growth Pack</h3><p class="text-slate-400 dark:text-slate-500 text-sm">Untuk bisnis pemula</p></div><div class="mb-6"><span class="text-5xl font-extrabold text-slate-900 dark:text-white">45k</span><span class="text-slate-500 dark:text-slate-400">/ 55 Kredit</span></div><ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-slate-300"><li class="flex items-center gap-3"><i class="fas fa-check-circle text-sky-500"></i> 50 Kredit Dasar</li><li class="flex items-center gap-3"><i class="fas fa-gift text-sky-500"></i> 5 Bonus Kredit</li><li class="flex items-center gap-3 text-slate-400 dark:text-slate-600"><i class="fas fa-times-circle"></i> Priority Support</li></ul><a href="{{ route('billing.index') }}" class="block w-full text-center py-3 border-2 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:border-sky-600 hover:text-sky-600 dark:hover:border-sky-500 dark:hover:text-sky-400 transition-colors">Beli</a></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border-2 border-sky-500 p-8 md:scale-110 z-10 glow-blue" data-aos="fade-up" data-aos-delay="200"><div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 gradient-bg text-white text-xs font-bold rounded-full uppercase tracking-wider shadow-lg">Best Value</div><div class="mb-6"><h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Business Pack</h3><p class="text-slate-400 dark:text-slate-500 text-sm">Paling diminati</p></div><div class="mb-6"><span class="text-5xl font-extrabold gradient-text">80k</span><span class="text-slate-500 dark:text-slate-400">/ 120 Kredit</span></div><ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-slate-300"><li class="flex items-center gap-3"><i class="fas fa-check-circle text-sky-500"></i> 100 Kredit Dasar</li><li class="flex items-center gap-3"><i class="fas fa-gift text-sky-500"></i> 20 Bonus Kredit</li><li class="flex items-center gap-3"><i class="fas fa-star text-sky-500"></i> Priority Support</li></ul><a href="{{ route('billing.index') }}" class="block w-full text-center py-3 gradient-bg text-white rounded-xl font-bold shadow-lg hover:shadow-sky-200 dark:hover:shadow-sky-900/30 transition-all">Beli Sekarang</a></div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-8 transition-all duration-300 hover:border-sky-200 dark:hover:border-sky-700 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300"><div class="mb-6"><h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Agency Pack</h3><p class="text-slate-400 dark:text-slate-500 text-sm">Skala besar & Marketer</p></div><div class="mb-6"><span class="text-5xl font-extrabold text-slate-900 dark:text-white">350k</span><span class="text-slate-500 dark:text-slate-400">/ 600 Kredit</span></div><ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-slate-300"><li class="flex items-center gap-3"><i class="fas fa-check-circle text-sky-500"></i> 500 Kredit Dasar</li><li class="flex items-center gap-3"><i class="fas fa-gift text-sky-500"></i> 100 Bonus Kredit</li><li class="flex items-center gap-3"><i class="fas fa-headset text-sky-500"></i> Dedicated Manager</li></ul><a href="{{ route('billing.index') }}" class="block w-full text-center py-3 border-2 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:border-sky-600 hover:text-sky-600 dark:hover:border-sky-500 dark:hover:text-sky-400 transition-colors">Beli</a></div>
            </div>
        </div>
    </section>

    <!-- ===================== PAYMENT METHODS (BARU) ==================== -->
    <section id="payments" class="py-20 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="text-sky-600 dark:text-sky-400 font-bold text-sm uppercase tracking-wider">Metode Pembayaran</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mt-3 mb-4">Bayar dengan Cara Favoritmu</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto">Proses top-up kredit instan dan aman. Didukung oleh berbagai metode pembayaran populer di Indonesia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- E-Wallet & QRIS -->
                <div class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl p-6 text-center hover:border-sky-200 dark:hover:border-sky-700 transition-all" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 text-purple-600 dark:text-purple-400">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3">E-Wallet & QRIS</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Scan QRIS atau bayar langsung dari saldo dompet digital.</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">QRIS</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">GoPay</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">OVO</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">DANA</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">ShopeePay</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">LinkAja</span>
                    </div>
                </div>

                <!-- Virtual Account / Mobile Banking -->
                <div class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl p-6 text-center hover:border-sky-200 dark:hover:border-sky-700 transition-all" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-sky-100 dark:bg-sky-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 text-sky-600 dark:text-sky-400">
                        <i class="fas fa-university text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3">Mobile & Internet Banking</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Transfer via Virtual Account dari aplikasi bank favorit.</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">BCA</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">BRI</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">Mandiri</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">BSI</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">Permata</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">CIMB</span>
                    </div>
                </div>

                <!-- Convenience Store / Retail -->
                <div class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl p-6 text-center hover:border-sky-200 dark:hover:border-sky-700 transition-all" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 text-amber-600 dark:text-amber-400">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3">Gerai Retail</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Bayar tunai tanpa perlu kartu kredit di kasir terdekat.</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">Alfamart</span>
                        <span class="px-3 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 shadow-sm">Indomaret</span>
                    </div>
                </div>
            </div>

            <!-- Security & Speed Badges -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-10 text-sm text-slate-500 dark:text-slate-400" data-aos="fade-up" data-aos-delay="400">
                <span class="flex items-center gap-2"><i class="fas fa-lock text-sky-500"></i> SSL Secured</span>
                <span class="flex items-center gap-2"><i class="fas fa-shield-halved text-sky-500"></i> 100% Transaksi Aman</span>
                <span class="flex items-center gap-2"><i class="fas fa-bolt text-sky-500"></i> Kredit Instan (1-5 Menit)</span>
            </div>
        </div>
    </section>

    <!-- ===================== FAQ ===================== -->
    <section id="faq" class="py-20 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up"><span class="text-sky-600 dark:text-sky-400 font-bold text-sm uppercase tracking-wider">FAQ</span><h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mt-3">Pertanyaan Umum</h2></div>
            <div class="space-y-4" data-aos="fade-up">
                <div class="faq-item border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden transition-all hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800"><button class="faq-toggle w-full flex justify-between items-center p-6 text-left focus:outline-none group"><span class="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-sky-600 dark:group-hover:text-sky-400">Apa itu sistem Kredit Token?</span><span class="ml-4 flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-sky-100 dark:group-hover:bg-sky-900/50 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors"><i class="fas fa-plus text-xs"></i></span></button><div class="faq-content hidden px-6 pb-6"><p class="text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-700 pt-4">Sistem ini memungkinkan Anda membayar hanya untuk fitur yang dipakai (Pay-as-you-go). Tidak ada biaya langganan bulanan yang mahal dan kredit tidak akan hangus.</p></div></div>
                <div class="faq-item border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden transition-all hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800"><button class="faq-toggle w-full flex justify-between items-center p-6 text-left focus:outline-none group"><span class="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-sky-600 dark:group-hover:text-sky-400">Berapa biaya generate 1 caption?</span><span class="ml-4 flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-sky-100 dark:group-hover:bg-sky-900/50 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors"><i class="fas fa-plus text-xs"></i></span></button><div class="faq-content hidden px-6 pb-6"><p class="text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-700 pt-4">Hanya 1 Kredit. Jika beli paket Growth, biaya per caption kurang dari Rp 1.000.</p></div></div>
                <div class="faq-item border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden transition-all hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800"><button class="faq-toggle w-full flex justify-between items-center p-6 text-left focus:outline-none group"><span class="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-sky-600 dark:group-hover:text-sky-400">Apakah ada kredit gratis?</span><span class="ml-4 flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-sky-100 dark:group-hover:bg-sky-900/50 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors"><i class="fas fa-plus text-xs"></i></span></button><div class="faq-content hidden px-6 pb-6"><p class="text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-700 pt-4">Ya! Setiap pengguna terdaftar mendapatkan 3 Kredit Gratis harian. Cukup login untuk klaim.</p></div></div>
            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 transition-colors duration-300">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-sky-500/10 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10" data-aos="zoom-in">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">Siap Skalakan Bisnismu<br>dengan Kekuatan AI?</h2>
            <p class="text-slate-400 mb-8 text-lg">Bergabung dengan ribuan UMKM yang sudah menikmati efisiensi marketing.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-white text-sky-600 font-bold rounded-2xl shadow-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors transform hover:scale-105"><span>Dapatkan 3 Kredit Gratis</span><i class="fas fa-arrow-right"></i></a>
        </div>
    </section>

    <!-- ===================== FOOTER ===================== -->
    <footer class="bg-slate-950 dark:bg-black text-slate-400 pt-16 pb-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1"><div class="flex items-center gap-2 mb-4"><img src="{{ asset('images/logo4.png') }}" alt="Larislo Logo" class="h-8 w-8 rounded-lg"><span class="text-lg font-bold text-white">LARISLO</span></div><p class="text-sm leading-relaxed">Platform AI Marketing terbaik untuk UMKM Indonesia.</p></div>
                <div><h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Produk</h4><ul class="space-y-2 text-sm"><li><a href="#features" class="hover:text-sky-400 transition-colors">AI Caption</a></li><li><a href="#features" class="hover:text-sky-400 transition-colors">Auto Posting</a></li><li><a href="#features" class="hover:text-sky-400 transition-colors">WhatsApp Bot</a></li></ul></div>
                <div><h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Perusahaan</h4><ul class="space-y-2 text-sm"><li><a href="#" class="hover:text-sky-400 transition-colors">Tentang Kami</a></li><li><a href="#" class="hover:text-sky-400 transition-colors">Blog</a></li><li><a href="#" class="hover:text-sky-400 transition-colors">Karir</a></li></ul></div>
                <div><h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Legal</h4><ul class="space-y-2 text-sm"><li><a href="#" class="hover:text-sky-400 transition-colors">Privasi</a></li><li><a href="#" class="hover:text-sky-400 transition-colors">Syarat & Ketentuan</a></li></ul></div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm">&copy; {{ date('Y') }} LARISLO. All rights reserved.</div>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full border border-slate-800 dark:border-slate-700 flex items-center justify-center hover:border-sky-500 hover:text-sky-500 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full border border-slate-800 dark:border-slate-700 flex items-center justify-center hover:border-sky-500 hover:text-sky-500 transition-colors"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full border border-slate-800 dark:border-slate-700 flex items-center justify-center hover:border-sky-500 hover:text-sky-500 transition-colors"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function landingLayout() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                init() { this.applyTheme(); },
                toggleDarkMode() { this.darkMode = !this.darkMode; this.applyTheme(); },
                applyTheme() {
                    if (this.darkMode) { document.documentElement.classList.add('dark'); localStorage.setItem('theme', 'dark'); }
                    else { document.documentElement.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
                }
            }
        }
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true });

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { navbar.classList.add('py-2'); navbar.querySelector('div').classList.add('shadow-lg'); }
            else { navbar.classList.remove('py-2'); navbar.querySelector('div').classList.remove('shadow-lg'); }
        });

        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        const navIcon = navToggle.querySelector('i');
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
            navIcon.classList.toggle('fa-bars'); navIcon.classList.toggle('fa-times');
        });
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => { navMenu.classList.add('hidden'); navIcon.classList.remove('fa-times'); navIcon.classList.add('fa-bars'); });
        });

        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const iconContainer = button.querySelector('span:last-child');
                const icon = iconContainer.querySelector('i');
                content.classList.toggle('hidden');
                if (content.classList.contains('hidden')) {
                    icon.classList.remove('fa-minus'); icon.classList.add('fa-plus');
                    iconContainer.classList.remove('bg-sky-100', 'dark:bg-sky-900/50', 'text-sky-600', 'dark:text-sky-400');
                    iconContainer.classList.add('bg-slate-100', 'dark:bg-slate-700', 'text-slate-500', 'dark:text-slate-400');
                } else {
                    icon.classList.remove('fa-plus'); icon.classList.add('fa-minus');
                    iconContainer.classList.remove('bg-slate-100', 'dark:bg-slate-700', 'text-slate-500', 'dark:text-slate-400');
                    iconContainer.classList.add('bg-sky-100', 'dark:bg-sky-900/50', 'text-sky-600', 'dark:text-sky-400');
                }
            });
        });
    </script>
</body>
</html>
