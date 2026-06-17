<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppBot extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_bots';

    protected $fillable = [
        'user_id',
        'business_id',
        'store_name',
        'phone_number',
        'api_key',
        'api_provider',
        'is_active',
        'is_configured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_configured' => 'boolean',
    ];

    // (Opsional) Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
