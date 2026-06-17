<?php

namespace App\Repositories;

use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionRepository
{
    protected $planModel;

    public function __construct(SubscriptionPlan $planModel)
    {
        $this->planModel = $planModel;
    }

    /**
     * Ambil semua daftar paket (Master Data).
     */
    public function getAllPlans()
    {
        return $this->planModel->all();
    }

    /**
     * Cari paket berdasarkan ID.
     */
    public function findPlan($id)
    {
        return $this->planModel->findOrFail($id);
    }

    /**
     * Cek apakah user memiliki akses ke fitur tertentu.
     * Contoh: Cek apakah boleh auto-posting.
     */
    public function userCan($user, $featureKey)
    {
        // Jika role admin, selalu boleh
        if ($user->role === 'admin') return true;

        $subscription = $user->subscriptionPlan; // Relasi belongsTo

        if (!$subscription) {
            return false; // Free user mungkin tidak punya relasi
        }

        // Logika sederhana: cek fitur di kolom JSON 'features'
        // Asumsi kolom features berisi ['scheduler' => true, 'ai_image' => true]
        return $subscription->features[$featureKey] ?? false;
    }

    /**
     * Aktifkan paket untuk user.
     */
    public function activatePlan(User $user, $planId)
    {
        $user->subscription_id = $planId;
        $user->role = 'pro'; // Update role otomatis saat upgrade
        $user->save();

        return $user;
    }

    /**
     * Cek limit kredit AI user berdasarkan paket.
     */
    public function checkCreditLimit(User $user)
    {
        $usage = (new AIContentRepository())->getMonthlyUsageCount($user->id);
        $limit = $user->subscriptionPlan->ai_credits_limit ?? 10; // Default 10 untuk free

        return [
            'used' => $usage,
            'limit' => $limit,
            'remaining' => max($limit - $usage, 0),
        ];
    }
}
