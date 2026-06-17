<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'price' => 49000,
                'duration_days' => 30,
                'ai_credits_limit' => 50,
                'scheduler_enabled' => false,
                'features' => json_encode([
                    'ai_caption' => true,
                    'ai_image' => false,
                    'scheduler' => false,
                    'analytics' => 'basic',
                ]),
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 149000,
                'duration_days' => 30,
                'ai_credits_limit' => 500,
                'scheduler_enabled' => true,
                'features' => json_encode([
                    'ai_caption' => true,
                    'ai_image' => true,
                    'ai_video' => false,
                    'scheduler' => true,
                    'analytics' => 'advanced',
                ]),
            ],
            [
                'name' => 'Agency',
                'slug' => 'agency',
                'price' => 499000,
                'duration_days' => 30,
                'ai_credits_limit' => 5000,
                'scheduler_enabled' => true,
                'features' => json_encode([
                    'ai_caption' => true,
                    'ai_image' => true,
                    'ai_video' => true,
                    'scheduler' => true,
                    'analytics' => 'full',
                    'team_member' => 5,
                    'workspace' => 'unlimited',
                ]),
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }

        $this->command->info('Subscription Plans seeded.');
    }
}
