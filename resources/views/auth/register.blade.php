<x-guest-layout>
    <div class="bg-white dark:bg-slate-800 p-8 md:p-10 rounded-3xl shadow-2xl border border-gray-100/50 dark:border-slate-700/50 w-full max-w-md relative overflow-hidden">
        <!-- Dekorasi Gradient Background -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-500 to-teal-400"></div>

        <div class="text-center mb-8 mt-2">
            <!-- Logo dari folder public/images -->
            <div class="mx-auto w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-4 overflow-hidden shadow-md">
                <img src="{{ asset('images/logo4.png') }}" alt="Logo Larislo" class="w-full h-full object-cover">
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Buat Akun Baru</h2>
            <p class="text-gray-400 dark:text-slate-400 text-sm mt-2">Bergabung dan tingkatkan bisnismu</p>
        </div>

        <!-- Tombol Google -->
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 dark:hover:border-slate-500 transition-all duration-300 group mb-6 shadow-sm">
             <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-gray-700 dark:text-slate-300 font-semibold text-sm group-hover:text-gray-900 dark:group-hover:text-white transition">Daftar dengan Google</span>
        </a>

        <!-- Pembatas -->
        <div class="flex items-center gap-4 mb-6">
            <div class="w-full h-px bg-gray-200 dark:bg-slate-600"></div>
            <span class="text-xs text-gray-400 dark:text-slate-500 uppercase font-bold">atau email</span>
            <div class="w-full h-px bg-gray-200 dark:bg-slate-600"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="space-y-5">
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-1.5 block" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <x-text-input id="name" class="w-full pl-11 pr-4 py-3 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-gray-50 dark:bg-slate-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500 font-medium" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-1.5 block" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <x-text-input id="email" class="w-full pl-11 pr-4 py-3 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-gray-50 dark:bg-slate-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-medium" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-1.5 block" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <x-text-input id="reg-password" class="w-full pl-11 pr-12 py-3 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-gray-50 dark:bg-slate-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />

                            <!-- EYE ICON TOGGLE -->
                            <button type="button" onclick="togglePassword('reg-password')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition">
                                <svg id="eye-icon-reg-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 font-medium" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-gray-700 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-1.5 block" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <x-text-input id="password_confirmation" class="w-full pl-11 pr-12 py-3 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-gray-50 dark:bg-slate-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />

                            <!-- EYE ICON TOGGLE -->
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition">
                                <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full justify-center bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 py-3.5 rounded-xl font-bold text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/30 hover:shadow-emerald-600/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    {{ __('Daftar Sekarang') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-500 dark:text-slate-400 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-emerald-600 dark:text-emerald-400 font-bold hover:text-emerald-800 dark:hover:text-emerald-300 hover:underline ml-1 transition">Masuk</a>
            </p>
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById('eye-icon-' + inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</x-guest-layout>
