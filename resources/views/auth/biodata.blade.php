<x-guest-layout>
    <div class="pt-5">
        <div class="mb-4 text-sm text-gray-600">
            Terima kasih telah mendaftar! Sebelum mulai, silakan lengkapi data toko Anda terlebih dahulu.
        </div>

        <form method="POST" action="{{ route('biodata.store') }}">
            @csrf

            <!-- Nama (Hanya Read-only) -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="auth()->user()->name" readonly />
            </div>

            <!-- Email (Hanya Read-only) -->
            <div class="mt-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="auth()->user()->email" readonly />
            </div>

            <!-- Nama Toko -->
            <div class="mt-4">
                <x-input-label for="store_name" value="Nama Toko / Bisnis" />
                <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name" required />
            </div>

            <!-- No Telpon -->
            <div class="mt-4">
                <x-input-label for="phone" value="Nomor Telepon / WhatsApp" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" />
            </div>

            <!-- Sosmed -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="instagram" value="Username Instagram" />
                    <x-text-input id="instagram" class="block mt-1 w-full" type="text" name="instagram" placeholder="@username" />
                </div>
                <div>
                    <x-input-label for="tiktok" value="Username TikTok" />
                    <x-text-input id="tiktok" class="block mt-1 w-full" type="text" name="tiktok" placeholder="@username" />
                </div>
                <div>
                    <x-input-label for="facebook" value="Link Facebook" />
                    <x-text-input id="facebook" class="block mt-1 w-full" type="text" name="facebook" />
                </div>
                <div>
                    <x-input-label for="twitter" value="Username Twitter / X" />
                    <x-text-input id="twitter" class="block mt-1 w-full" type="text" name="twitter" />
                </div>
                <div>
                    <x-input-label for="threads" value="Username Threads" />
                    <x-text-input id="threads" class="block mt-1 w-full" type="text" name="threads" />
                </div>
                <div>
                    <x-input-label for="other_social" value="Sosial Media Lainnya" />
                    <x-text-input id="other_social" class="block mt-1 w-full" type="text" name="other_social" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    Simpan & Lanjutkan
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
