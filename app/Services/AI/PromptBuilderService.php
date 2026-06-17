<?php

namespace App\Services\AI;

class PromptBuilderService
{
    public function buildCaptionPrompt(array $data): string
    {
        $tone = $data['tone'] ?? 'informative';
        $productName = $data['product_name'] ?? 'Produk';
        $promo = $data['promo'] ?? '';

        $prompt = "Anda adalah seorang Social Media Specialist profesional. ";
        $prompt .= "Buatkan caption marketing yang menarik dengan gaya bahasa {$tone}. ";
        $prompt .= "Detail Produk: {$productName}. ";

        if ($promo) {
            $prompt .= "Promo: {$promo}. ";
        }

        $prompt .= "Target pasar: {$data['target_market']}. ";
        $prompt .= "Sertakan hook di awal, emoji yang relevan, dan CTA yang kuat di akhir. ";
        $prompt .= "Tambahkan 5-10 hashtag yang relevan.";

        return $prompt;
    }

    public function buildImagePrompt(string $description): string
    {
        return "High quality product photography, {$description}, professional lighting, 4k resolution, bokeh background, commercial style";
    }
}
