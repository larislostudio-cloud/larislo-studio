<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class InstagramService
{
    public function publish($accessToken, $igId, $caption, $imageUrl)
    {
        // Step 1: Create Media Container
        $createResponse = Http::get('https://graph.facebook.com/v19.0/' . $igId . '/media', [
            'image_url' => $imageUrl,
            'caption' => $caption,
            'access_token' => $accessToken,
        ]);

        if ($createResponse->failed()) return false;

        $creationId = $createResponse->json('id');

        // Step 2: Publish Container
        $publishResponse = Http::post('https://graph.facebook.com/v19.0/' . $igId . '/media_publish', [
            'creation_id' => $creationId,
            'access_token' => $accessToken,
        ]);

        return $publishResponse->successful();
    }
}
