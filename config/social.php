<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Facebook & Instagram (Meta Graph API)
    |--------------------------------------------------------------------------
    */
    'facebook' => [
        'client_id' => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect_uri' => env('FB_REDIRECT_URI'),
        'graph_version' => 'v19.0',
        // Scope untuk izin akses
        'scopes' => ['email', 'public_profile', 'pages_show_list', 'pages_read_engagement', 'pages_manage_posts', 'instagram_basic', 'instagram_content_publish'],
    ],

    /*
    |--------------------------------------------------------------------------
    | TikTok
    |--------------------------------------------------------------------------
    */
    'tiktok' => [
        'client_key' => env('TIKTOK_CLIENT_KEY'),
        'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        'redirect_uri' => env('TIKTOK_REDIRECT_URI'),
        'scopes' => ['user.info.basic', 'video.publish', 'video.upload'],
    ],

    /*
    |--------------------------------------------------------------------------
    | General Scheduler Settings
    |--------------------------------------------------------------------------
    */
    'scheduler' => [
        // Jumlah maksimal post yang bisa dijadwalkan sekaligus (Bulk)
        'bulk_limit' => 50,
        // Waktu default 'gap' antar posting (menit)
        'posting_gap' => 5,
    ],
];
