<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class ApiRateLimiter
{
    public function handle(Request $request, Closure $next, string $limit = '10,1'): Response
    {
        // Limit format: "max_attempts,decay_minutes"
        [$maxAttempts, $decayMinutes] = explode(',', $limit);

        $key = 'api_limit_' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, (int)$maxAttempts)) {
            return response()->json([
                'message' => 'Terlalu banyak permintaan. Coba lagi nanti.'
            ], 429);
        }

        RateLimiter::hit($key, (int)$decayMinutes * 60);

        return $next($request);
    }
}
