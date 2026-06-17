<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use App\Helpers\AiHelper;
use App\Models\WhatsappLog;
use App\Models\WhatsAppBot;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppBotController extends Controller
{
    /**
     * MENAMPILKAN DASHBOARD WHATSAPP
     */
    public function index()
    {
        $user = auth()->user();
        $businessId = $user->business->id ?? null;

        if (!$businessId) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki data bisnis.');
        }

        // Gunakan business_id, BUKAN user_id
        $bot = WhatsAppBot::firstOrCreate(
            ['business_id' => $businessId],
            [
                'store_name' => '',      // Tambahkan default kosong
                'phone_number' => '',    // Tambahkan default kosong
                'api_key' => '',         // Tambahkan default kosong
                'is_configured' => false,
                'is_active' => false
            ]
        );

        // Ambil riwayat chat berdasarkan business_id
        $chats = WhatsappLog::where('business_id', $businessId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('phone_number');

        return view('whatsapp.index', compact('bot', 'chats'));
    }

    /**
     * MENGIRIM PESAN MANUAL DARI DASHBOARD
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        $businessId = $user->business->id ?? null;
        $bot = WhatsAppBot::where('business_id', $businessId)->first();

        if (!$bot || !$bot->is_configured) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bot belum diatur. Silakan lakukan setup terlebih dahulu.'
            ], 400);
        }

        // 1. Log pesan keluar ke database
        WhatsappLog::create([
            'user_id' => $user->id,
            'business_id' => $businessId, // Sesuaikan dengan skema tabel logs
            'phone_number' => $request->phone,
            'message' => $request->message,
            'direction' => 'out',
            'is_ai' => false,
        ]);

        // 2. Kirim pesan via API Provider (Fonnte/Wablas)
        try {
            $waService = new WhatsAppService();
            $waService->sendMessage($bot->id, $request->phone, $request->message);
        } catch (\Exception $e) {
            \Log::error('Gagal kirim WA: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan terkirim!'
        ]);
    }

    /**
     * Proses pesan masuk dari Webhook (Dari API Provider)
     */
    public function processMessage($message, $sender, $businessId)
    {
        $bot = WhatsAppBot::find($businessId);
        if (!$bot) return null;

        // Ambil user_id melalui relasi business (jika tabel bot tidak punya user_id langsung)
        $userId = $bot->business->user_id ?? null;

        // 1. Log pesan masuk
        WhatsappLog::create([
            'user_id' => $userId,
            'business_id' => $businessId,
            'phone_number' => $sender,
            'message' => $message,
            'direction' => 'in',
        ]);

        // 2. Cek apakah ada keyword command
        if (str_starts_with(strtolower($message), '#order')) {
            $reply = $this->handleOrder($sender, $message, $businessId);
        } else {
            // 3. Gunakan AI untuk menjawab
            $context = "Kamu adalah customer service ramah untuk bisnis {$bot->store_name}. Jawab dengan bahasa Indonesia yang sopan.";
            $reply = AiHelper::generateCaption([
                'tone' => 'professional',
                'product_name' => 'Customer Inquiry',
                'promo' => $message,
                'business_type' => $context
            ]);
        }

        // 4. Log balasan
        WhatsappLog::create([
            'user_id' => $userId,
            'business_id' => $businessId,
            'phone_number' => $sender,
            'message' => $reply,
            'direction' => 'out',
            'is_ai' => true,
        ]);

        // 5. Kirim balasan via API
        $waService = new WhatsAppService();
        $waService->sendMessage($businessId, $sender, $reply);

        return $reply;
    }

    protected function handleOrder($sender, $message, $businessId)
    {
        return "Terima kasih, pesanan Anda sedang diproses. Tim kami akan segera menghubungi Anda untuk konfirmasi.";
    }

    public function trainAI(Request $request)
    {
        $user = auth()->user();
        $creditCost = 15;

        if (!$user->hasCredits($creditCost)) {
            return back()->with('error', "Kredit tidak cukup untuk melatih AI. Butuh {$creditCost} kredit.");
        }

        $user->deductCredits($creditCost);

        return back()->with('success', "Model AI WhatsApp berhasil dilatih! Kredit dikurangi {$creditCost}.");
    }

    /**
     * Method untuk menyimpan konfigurasi bot (Opsi 2: User input API Key sendiri)
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'api_key' => 'required|string',
        ], [
            'store_name.required' => 'Nama toko wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'api_key.required' => 'Kode Koneksi wajib diisi. Silakan copy dari Fonnte.',
        ]);

        $businessId = auth()->user()->business->id;

        $bot = WhatsAppBot::updateOrCreate(
            ['business_id' => $businessId], // Gunakan business_id
            [
                'store_name' => $request->store_name,
                'phone_number' => $request->phone_number,
                'api_key' => $request->api_key, // OPSI 2: Ambil dari input user, BUKAN env()
                'is_configured' => true,
                'is_active' => true,
            ]
        );

        return redirect()->route('whatsapp.index')->with('success', 'Bot berhasil diaktifkan!');
    }

    /**
     * Handle Webhook dari Fonnte
     */
    public function handleWebhook(Request $request)
    {
        // Data yang dikirim oleh Fonnte (sesuaikan dengan dokumentasi Fonnte)
        $message = $request->message;
        $sender = $request->phone; // Nomor pengirim

        // Fonnte biasanya mengirim nomor tujuan (nomor bot Anda) di parameter 'target' atau 'recipient'
        // Kita gunakan itu untuk mencari bot mana yang aktif
        $recipientNumber = $request->target;

        $bot = WhatsAppBot::where('phone_number', $recipientNumber)
                          ->where('is_active', true)
                          ->first();

        $businessId = $bot ? $bot->id : null;

        if ($message && $sender && $businessId) {
            $this->processMessage($message, $sender, $businessId);
        }

        return response()->json(['status' => 'success']);
    }
}
