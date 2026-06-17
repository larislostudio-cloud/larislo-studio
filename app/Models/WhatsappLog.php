<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'phone_number',
        'message',
        'direction',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
