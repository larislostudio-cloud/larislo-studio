<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Payment Gateway
    |--------------------------------------------------------------------------
    */
    'midtrans' => [
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
        'is_sanitized' => true,
        'is_3ds' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Xendit Payment Gateway (Alternatif)
    |--------------------------------------------------------------------------
    */
    'xendit' => [
        'secret_key' => env('XENDIT_SECRET_KEY'),
        'public_key' => env('XENDIT_PUBLIC_KEY'),
        'callback_token' => env('XENDIT_CALLBACK_TOKEN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Rules
    |--------------------------------------------------------------------------
    */
    'subscription' => [
        // Masa tenggang setelah expire (hari)
        'grace_period' => 3,
        // Persentase komisi marketplace
        'marketplace_fee_percent' => 20,
    ],
];
