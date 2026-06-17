<?php

namespace App\Jobs\AI;

use App\Helpers\AiHelper;
use App\Helpers\MediaHelper;
use App\Models\AiContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $prompt;

    public function __construct($userId, string $prompt)
    {
        $this->userId = $userId;
        $this->prompt = $prompt;
    }

    public function handle(): void
    {
        try {
            // 1. Enhance prompt
            $enhancedPrompt = AiHelper::buildImagePrompt($this->prompt);

            // 2. Panggil API Image (DALL-E / Stability AI)
            // Contoh simülasi hasil URL (dunia nyata: menerima binary atau URL dari API)
            $imageUrl = 'https://placehold.co/600x400?text=AI+Generated';
            // $imageBinary = OpenAI::image($enhancedPrompt);

            // 3. Simpan ke storage lokal jika perlu
            // $path = MediaHelper::uploadFromUrl($imageUrl, 'ai-images');

            // 4. Simpan log ke DB
            AiContent::create([
                'user_id' => $this->userId,
                'type'    => 'image',
                'prompt'  => $this->prompt,
                'result'  => $imageUrl, // atau path lokal
            ]);

        } catch (\Exception $e) {
            Log::error('GenerateImageJob Failed: ' . $e->getMessage());
        }
    }
}
