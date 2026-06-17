<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppBot;
use Illuminate\Http\Request;

class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request)
    {
        $verifyToken = env('WA_VERIFY_TOKEN', 'default_token_larislo');
        $mode = $request->hub_mode;
        $token = $request->hub_verify_token;
        $challenge = $request->hub_challenge;

        if ($mode === 'subscribe' && $token === $verifyToken) {
            return response($challenge, 200);
        }
        return response('Forbidden', 403);
    }

    public function handle(Request $request, WhatsAppBotController $bot)
    {
        // Struktur data dari Fonnte / Meta akan berbeda. Ini contoh Fonnte:
        $data = $request->all();

        // Validasi sederhana
        if (isset($data['message']) && isset($data['sender'])) {
            $message = $data['message'];
            $sender = $data['sender']; // Format: 6281234567890
            $devicePhone = $data['target'] ?? null; // Nomor WA bisnis

            // Cari business_id berdasarkan nomor WA yang menerima
            $botConfig = WhatsAppBot::where('phone_number', $devicePhone)->first();

            if ($botConfig) {
                $bot->processMessage($message, $sender, $botConfig->business_id);
            }
        }

        return response('OK', 200);
    }
}
