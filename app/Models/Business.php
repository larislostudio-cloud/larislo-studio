<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'niche',
        'logo',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function analytics()
    {
        return $this->hasMany(Analytics::class);
    }

    public function whatsappBot()
    {
        return $this->hasOne(WhatsAppBot::class);
    }
}
