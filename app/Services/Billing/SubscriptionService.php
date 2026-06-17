<?php

namespace App\Services\Billing;

use App\Models\User;
use App\Models\SubscriptionPlan;

class SubscriptionService
{
    public function activate(User $user, SubscriptionPlan $plan)
    {
        $user->update([
            'subscription_id' => $plan->id,
            'role' => $this->getRoleFromPlan($plan->slug)
        ]);

        // Trigger event
        // event(new SubscriptionActivated($user));
    }

    protected function getRoleFromPlan($slug)
    {
        return match($slug) {
            'pro' => 'pro',
            'agency' => 'agency',
            default => 'free'
        };
    }
}
