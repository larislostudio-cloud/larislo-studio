<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status', // idea, draft, scheduled
        'plan_date',
    ];

    protected $casts = [
        'plan_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
