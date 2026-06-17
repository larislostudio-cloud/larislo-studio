<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIContent extends Model
{
    use HasFactory;

    protected $table = 'ai_contents';

    protected $fillable = [
        'user_id',
        'type',
        'prompt',
        'project_data',
        'status',
        'output_url',
    ];

    protected $casts = [
        'project_data' => 'array', // Merubah data JSON otomatis ke Array PHP
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
