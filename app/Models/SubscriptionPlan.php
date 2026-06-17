<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $table = 'subscription_plans'; // Define table name explicitly if needed

    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration_days',
        'ai_credits_limit',
        'features', // JSON field
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'subscription_id');
    }
}
