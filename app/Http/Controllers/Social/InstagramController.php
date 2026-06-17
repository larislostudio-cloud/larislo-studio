<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    // Redirect user ke halaman login Facebook/Instagram
    public function connect()
    {
        $query = http_build_query([
            'client_id' => env('FB_CLIENT_ID'),
            'redirect_uri' => env('FB_REDIRECT_URI'),
            'scope' => 'instagram_basic,pages_show_list',
            'response_type' => 'code',
        ]);

        return redirect('https://www.facebook.com/v18.0/dialog/oauth?' . $query);
    }

    // Handle callback setelah user approve
    public function callback(Request $request)
    {
        $code = $request->code;

        // Tukar code dengan Access Token
        $response = Http::get('https://graph.facebook.com/v18.0/oauth/access_token', [
            'client_id' => env('FB_CLIENT_ID'),
            'client_secret' => env('FB_CLIENT_SECRET'),
            'redirect_uri' => env('FB_REDIRECT_URI'),
            'code' => $code,
        ]);

        $accessToken = $response->json('access_token');

        // Simpan token ke database user (social_accounts table)
        auth()->user()->socialAccounts()->updateOrCreate(
            ['platform' => 'instagram'],
            ['access_token' => $accessToken]
        );

        return redirect()->route('settings.socials')->with('success', 'Instagram terhubung!');
    }
}

// Class yang sama bisa digunakan untuk Facebook dengan scope yang berbeda.
// Untuk TikTok dan LinkedIn, ganti URL OAuth dan parameter scope sesuai dokumentasi API masing-masing.
