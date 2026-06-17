<?php

namespace App\Services;

use App\Models\WhatsAppBot;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected $adminApiKey;
    protected $adminNumber;

    public function __construct()
    {
        // Ambil konfigurasi khusus Admin dari .env
        $this->adminApiKey = env('WA_ADMIN_API_KEY');
        $this->adminNumber = env('ADMIN_WA_NUMBER');
    }

    /**
     * Kirim pesan ke WhatsApp melalui API Provider (Fonnte)
     * Digunakan untuk membalas chat pelanggan (Bot milik User)
     */
    public function sendMessage($businessId, $destinationPhone, $message)
    {
        $bot = WhatsAppBot::where('business_id', $businessId)->first();

        if (!$bot || !$bot->is_active || !$bot->api_key) {
            Log::error("Bot tidak aktif atau API Key belum diset untuk Business ID: {$businessId}");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $bot->api_key
            ])->post('https://api.fonnte.com/send', [
                'target' => $destinationPhone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (User Bot): ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi ke WhatsApp Admin
     * Digunakan untuk notifikasi sistem (misal: pembayaran sukses dari Midtrans)
     */
    public function notifyAdmin(string $message): bool
    {
        if (!$this->adminApiKey || !$this->adminNumber) {
            Log::warning('WA Admin Notification Gagal: API Key atau Nomor Admin belum diatur di .env (WA_ADMIN_API_KEY & ADMIN_WA_NUMBER)');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->adminApiKey
            ])->post('https://api.fonnte.com/send', [
                'target'      => $this->adminNumber,
                'message'     => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                Log::info("Notifikasi WA berhasil dikirim ke Admin.");
                return true;
            } else {
                Log::error("Notifikasi WA Gagal dikirim. Response: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception WA Service (Admin): " . $e->getMessage());
            return false;
        }
    }
}
