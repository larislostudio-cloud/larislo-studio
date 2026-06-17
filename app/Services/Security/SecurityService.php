<?php

namespace App\Services\Security;

class SecurityService
{
    public function maskApiKey($key)
    {
        return substr($key, 0, 4) . '****' . substr($key, -4);
    }

    public function logSuspiciousActivity($userId, $action)
    {
        // Log aktivitas mencurigakan
        \Log::warning("Suspicious Activity: User {$userId} - Action: {$action}");
    }
}
