<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiHelper
{
    /**
     * Generate Caption menggunakan OpenAI API.
     *
     * @param array $data (business_type, product_name, promo, target_market, tone)
     * @return string|null
     */
    public static function generateCaption(array $data)
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            Log::error('OpenAI API Key is not set.');
            return null;
        }

        // Bangun Prompt dinamis
        $prompt = "Buatkan caption marketing yang menarik untuk media sosial dengan detail berikut:\n";
        $prompt .= "- Jenis Bisnis: " . ($data['business_type'] ?? 'UMKM') . "\n";
        $prompt .= "- Nama Produk: " . ($data['product_name'] ?? 'Produk') . "\n";
        $prompt .= "- Promo: " . ($data['promo'] ?? 'Tidak ada promo khusus') . "\n";
        $prompt .= "- Target Market: " . ($data['target_market'] ?? 'Umum') . "\n";
        $prompt .= "- Gaya Bahasa: " . ($data['tone'] ?? 'Santai') . "\n\n";
        $prompt .= "Sertakan Hook yang menarik, Emoji yang relevan, dan CTA yang kuat. Sertakan juga 5-10 hashtag yang relevan.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Atau gpt-4
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah seorang Social Media Specialist ahli copywriting.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenAI API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('AiHelper Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate prompt untuk image generation (misal DALL-E atau Stable Diffusion).
     *
     * @param string $description
     * @return string
     */
    public static function buildImagePrompt(string $description)
    {
        // Helper untuk memperkaya prompt user agar hasil AI lebih bagus
        return "Professional product photography, $description, high resolution, 4k, soft lighting, bokeh background, marketing material style";
    }
}
