<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use App\Models\WhatsappLog;
use App\Models\WhatsAppBot;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppMessageController extends Controller
{
    // HAPUS FUNGSI __construct() SEPERTI DI BAWAH INI:
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
        {
            $user = auth()->user();

            // Jika belum punya bisnis
            if (!$user->business) {
                $contactsJson = '[]';
                $chatDataJson = '{}';
                $bot = null;
                return view('whatsapp.index', compact('contactsJson', 'chatDataJson', 'bot'))->with('warning', 'Anda belum memiliki profil bisnis. Silakan buat di menu Settings.');
            }

            $businessId = $user->business->id;

            // Ambil log chat
            $chats = WhatsappLog::where('business_id', $businessId)
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->groupBy('phone_number');

            // Siapkan data JSON untuk kontak
            $contactsJson = $chats->map(function($messages, $phone) {
                $lastMsg = $messages->first();
                return [
                    'id' => $phone,
                    'name' => $phone,
                    'avatar' => substr($phone, -2),
                    'lastMsg' => \Illuminate\Support\Str::limit($lastMsg->message, 30),
                    'time' => $lastMsg->created_at->format('H:i'),
                    'unread' => 0, // Anda bisa menambahkan kolom 'is_read' di migrasi nanti
                    'online' => false,
                    'bot' => false,
                    'color' => 'from-emerald-400 to-teal-500'
                ];
            })->values()->toJson();

            // Siapkan data JSON untuk isi chat
            $chatDataJson = $chats->mapWithKeys(function($messages, $phone) {
                return [
                    $phone => $messages->reverse()->map(function($m) {
                        return [
                            'type' => $m->direction === 'in' ? 'in' : 'out',
                            'text' => $m->message,
                            'time' => $m->created_at->format('H:i'),
                            'bot' => false,
                        ];
                    })->prepend(['type' => 'date', 'text' => $messages->first()->created_at->format('d M Y')])->values()
                ];
            })->toJson();

            // 1. Ambil business_id dari user yang login
            $businessId = auth()->user()->business->id ?? null;

            // 2. Jika user belum punya business, redirect dengan pesan error
            if (!$businessId) {
                return redirect()->route('dashboard')->with('error', 'Anda belum memiliki data bisnis.');
            }

            // 3. Cari atau buat bot berdasarkan business_id
            $bot = WhatsAppBot::firstOrCreate(
                ['business_id' => $businessId],
                [
                    'store_name' => '',          // Tambahkan default kosong
                    'phone_number' => '',        // Tambahkan default kosong
                    'api_key' => '',             // Tambahkan default kosong
                    'is_configured' => false,
                    'is_active' => false
                ]
            );

            return view('whatsapp.index', compact('contactsJson', 'chatDataJson', 'bot'));
        }

    public function sendManual(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required'
        ]);

        $user = auth()->user();
        $businessId = $user->business->id;

        // 1. Log pesan keluar
        WhatsappLog::create([
            'business_id' => $businessId,
            'phone_number' => $request->phone,
            'message' => $request->message,
            'direction' => 'out',
        ]);

        // 2. Kirim via Service
        $waService = new WhatsAppService();
        $sent = $waService->sendMessage($businessId, $request->phone, $request->message);

        if ($sent) {
            return response()->json(['status' => 'success', 'message' => 'Pesan terkirim!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan. Cek API Key.'], 500);
    }
}
