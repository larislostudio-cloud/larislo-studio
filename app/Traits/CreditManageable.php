<?php

namespace App\Traits;

use App\Exceptions\InsufficientCreditsException;

trait CreditManageable
{
    /**
     * Cek apakah user memiliki kredit yang cukup.
     */
    public function hasCredits(int $amount = 1): bool
    {
        $limit = optional($this->subscriptionPlan)->ai_credits_limit ?? 0;
        $usage = $this->aiContents()->whereMonth('created_at', now()->month)->count();

        return ($usage + $amount) <= $limit;
    }

    /**
     * Kurangi kredit user (digunakan saat generate AI).
     * Di sini kita hanya mencatat usage via AIContent,
     * tapi bisa juga implementasi sistem saldo (balance) jika diperlukan.
     */
    public function deductCredit(int $amount = 1): void
    {
        if (!$this->hasCredits($amount)) {
            throw new InsufficientCreditsException();
        }

        // Logika pengurangan saldo jika sistemnya pakai balance
        // $this->decrement('balance', $amount);
    }

    /**
     * Dapatkan sisa kredit user bulan ini.
     */
    public function getRemainingCredits(): int
    {
        $limit = optional($this->subscriptionPlan)->ai_credits_limit ?? 0;
        $usage = $this->aiContents()->whereMonth('created_at', now()->month)->count();

        return max($limit - $usage, 0);
    }
}
