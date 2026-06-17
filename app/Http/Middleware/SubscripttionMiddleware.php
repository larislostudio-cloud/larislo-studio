<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    public function handle(Request $request, Closure $next, $plan = 'pro'): Response
    {
        $user = auth()->user();

        // Jika user belum punya subscription (Free user)
        if (!$user->subscription) {
            // Cek apakah fitur ini bisa diakses free user (berdasarkan logic sederhana)
            // Jika tidak, redirect ke halaman billing
            return redirect()->route('billing.index')
                ->with('error', 'Silakan upgrade paket Anda untuk mengakses fitur ini.');
        }

        // Cek jika paket user tidak memenuhi syarat (misal butuh 'agency' tapi user 'pro')
        $allowedRoles = ['pro', 'agency', 'admin'];
        if (!in_array($user->role, $allowedRoles)) {
             abort(403, 'Fitur ini membutuhkan paket minimal Pro.');
        }

        return $next($request);
    }
}
