<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'original_url',
        'short_code',
        'clicks',
        'conversions',
    ];

    protected $casts = [
        'clicks' => 'integer',
        'conversions' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
