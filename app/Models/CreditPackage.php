<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPackage extends Model
{
    protected $fillable = ['name', 'credits', 'price', 'bonus', 'is_active'];

    public function getTotalCreditsAttribute(): int
    {
        return $this->credits + $this->bonus;
    }
}
