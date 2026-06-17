<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API (Meta Cloud API)
    |--------------------------------------------------------------------------
    */
    'token' => env('WHATSAPP_TOKEN'), // Permanent Token dari Meta Developer
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Verification
    |--------------------------------------------------------------------------
    */
    'verify_token' => env('WHATSAPP_VERIFY_TOKEN'), // Token custom untuk verifikasi webhook

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    */
    'api_version' => 'v19.0', // Sesuaikan dengan versi API yang digunakan

    /*
    |--------------------------------------------------------------------------
    | Auto Reply Settings
    |--------------------------------------------------------------------------
    */
    'auto_reply' => [
        'enabled' => true,
        'greeting' => 'Halo! Terima kasih telah menghubungi kami. Ada yang bisa kami bantu?',
        'fallback' => 'Maaf, kami sedang tidak online. Silakan tinggalkan pesan.',
    ],
];
