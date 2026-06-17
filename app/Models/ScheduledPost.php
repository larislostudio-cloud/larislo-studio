<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform', // instagram, facebook, tiktok
        'content',
        'media_path',
        'publish_at',
        'status', // draft, scheduled, published, failed
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
