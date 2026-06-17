<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'subscription_plan_id',
        'amount',      // Jumlah Kredit
        'price',       // <--- TAMBAHKAN INI (Harga Paket)
        'payment_method',
        'status', // pending, success, failed
        'payload', // Raw response dari payment gateway
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke CreditPackage (jika ada foreign key,
     * jika tidak bisa diabaikan atau dibuat relasi berbasis ID manual)
     */
    public function creditPackage()
    {
        // Jika Anda menyimpan package_id di tabel transactions
        // return $this->belongsTo(CreditPackage::class);
        return null;
    }
}
