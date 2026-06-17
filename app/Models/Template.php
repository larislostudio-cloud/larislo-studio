<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'price',
        'description',
        'file_path',
        'thumbnail',
        'status',
        'views',
    ];

    /**
     * Relasi ke User (Pembuat/Vendor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
