<?php

namespace App\Traits;

use App\Models\SubscriptionPlan;

trait HasSubscription
{
    /**
     * Cek apakah user berlangganan paket tertentu.
     */
    public function isSubscribedTo(string $planSlug): bool
    {
        if ($this->role === 'admin') return true;

        return optional($this->subscriptionPlan)->slug === $planSlug;
    }

    /**
     * Cek apakah user adalah pengguna Pro atau lebih tinggi.
     */
    public function isPro(): bool
    {
        return in_array($this->role, ['pro', 'agency', 'admin']);
    }

    /**
     * Cek apakah user adalah Agency.
     */
    public function isAgency(): bool
    {
        return in_array($this->role, ['agency', 'admin']);
    }

    /**
     * Cek apakah user memiliki akses ke fitur tertentu.
     * (Logika ini bisa disesuaikan dengan kolom JSON 'features' di tabel subscription_plans)
     */
    public function hasFeature(string $featureKey): bool
    {
        if ($this->role === 'admin') return true;

        $plan = $this->subscriptionPlan;

        if (!$plan) return false;

        // Asumsi ada kolom 'features' bertipe JSON/Array di model SubscriptionPlan
        return $plan->features[$featureKey] ?? false;
    }
}
