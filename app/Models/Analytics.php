<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'date',
        'engagement',
        'views',
        'followers_growth',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
