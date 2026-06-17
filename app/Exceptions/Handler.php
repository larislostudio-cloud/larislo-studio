<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * Daftar tipe exception yang tidak boleh dilaporkan (report).
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Daftar input yang tidak perlu di-flash ke session saat validasi error.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register callback untuk report exception.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Kirim notifikasi error ke Slack/Email jika kritis
            if ($e instanceof \App\Exceptions\CriticalSystemError) {
                // Notification::route('mail', 'dev@larislo.com')->notify(...);
            }
        });
    }

    /**
     * Custom render untuk exception tertentu (opsional).
     * Bisa digunakan untuk mengembalikan JSON response khusus untuk API.
     */
    public function render($request, Throwable $e)
    {
        // Jika request mengharapkan JSON (API Call)
        if ($request->expectsJson()) {

            // Handle Custom Exception: Saldo Tidak Cukup
            if ($e instanceof \App\Exceptions\InsufficientCreditsException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kredit AI Anda tidak mencukupi.',
                    'action'  => 'redirect_billing'
                ], 402); // 402 Payment Required
            }

            // Handle Custom Exception: API Pihak Ketiga Error (Instagram/TikTok)
            if ($e instanceof \App\Exceptions\SocialApiException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung ke ' . $e->getServiceName() . '. Silakan coba lagi.',
                ], 502);
            }
        }

        return parent::render($request, $e);
    }
}
