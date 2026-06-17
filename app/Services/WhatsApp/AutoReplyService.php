<?php

namespace App\Services\WhatsApp;

use App\Services\AI\OpenAIService;

class AutoReplyService
{
    protected $ai;
    protected $waService;

    public function __construct(OpenAIService $ai, WhatsAppService $waService)
    {
        $this->ai = $ai;
        $this->waService = $waService;
    }

    public function handleIncomingMessage($from, $message, $businessContext)
    {
        // 1. Cek keyword sederhana
        if (str_contains(strtolower($message), 'harga')) {
            $reply = "Halo, berikut adalah daftar harga kami: ...";
        } else {
            // 2. Gunakan AI jika tidak ada keyword spesifik
            $prompt = "Anda adalah CS untuk {$businessContext}. Jawab pertanyaan berikut: " . $message;
            $reply = $this->ai->chat($prompt);
        }

        // 3. Kirim balasan
        return $this->waService->sendMessage($from, $reply);
    }
}
