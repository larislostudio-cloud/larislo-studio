<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    public function publish($accessToken, $pageId, $message, $link = null)
    {
        $response = Http::asForm()->post('https://graph.facebook.com/v19.0/' . $pageId . '/feed', [
            'message' => $message,
            'link' => $link,
            'access_token' => $accessToken,
        ]);

        return $response->successful();
    }
}
