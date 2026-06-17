<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone', 'instagram', 'tiktok',
        'facebook', 'twitter', 'threads', 'other_social'
    ];

    // Relasi: Satu toko milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
