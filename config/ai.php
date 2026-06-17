<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Provider Settings
    |--------------------------------------------------------------------------
    */

    // Konfigurasi OpenAI
    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'), // Model default untuk text
        'image_model' => env('OPENAI_IMAGE_MODEL', 'dall-e-3'),
    ],

    // Konfigurasi Replicate (untuk Video/Spesific Image models)
    'replicate' => [
        'api_token' => env('REPLICATE_API_TOKEN'),
        'video_model' => 'anotherjesse/zeroscope-v2-xl:9f747673945c62801b13b84701c783929c0ee784e4748ec062204894dda1a351',
    ],

    /*
    |--------------------------------------------------------------------------
    | Credit & Limits
    |--------------------------------------------------------------------------
    */

    // Batas kredit default untuk user Free (jika tidak ada di DB)
    'free_tier_limit' => env('AI_FREE_LIMIT', 10),

    // Biaya per request (dalam kredit)
    'costs' => [
        'caption' => 1,
        'image' => 5,
        'video' => 20,
        'voice' => 3,
    ],
];
