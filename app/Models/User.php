<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasSubscription;
use App\Traits\CreditManageable;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSubscription, CreditManageable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // Kolom 'role', 'credits', 'subscription_id' sengaja tidak ada di sini (keamanan)
        'balance',
        'last_daily_credit_at',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
        'last_daily_credit_at' => 'datetime',
    ];

    // ================= RELATIONS =================

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function aiContents()
    {
        return $this->hasMany(AIContent::class);
    }

    public function scheduledPosts()
    {
        return $this->hasMany(ScheduledPost::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ================= CUSTOM METHODS =================

    /**
     * Method khusus untuk menetapkan role.
     */
    public function assignRole(string $role): void
    {
        $this->update(['role' => $role]);
    }

    /**
     * Cek apakah user memiliki kredit cukup.
     */
    public function hasCredits($amount = 1): bool
    {
        return $this->credits >= $amount;
    }

    /**
     * Kurangi kredit user dengan aman (Menggunakan Transaction & Lock).
     */
    public function deductCredits(int $amount): bool
    {
        // Gunakan transaction untuk menghindari Race Condition
        return DB::transaction(function () use ($amount) {
            // Refresh data user dari DB dan kunci barisnya
            $user = User::where('id', $this->id)->lockForUpdate()->first();

            if ($user->credits < $amount) {
                return false;
            }

            $user->credits -= $amount;
            $user->save();

            return true;
        });
    }

    /**
     * Tambah kredit user.
     */
    public function addCredits(int $amount): void
    {
        $this->increment('credits', $amount);
    }

    /**
     * Method untuk memberikan kredit harian gratis dengan Batas Maksimal (Cap).
     */
    public function grantDailyFreeCredits(): bool
    {
        // 1. Cek apakah hari ini sudah pernah dikasih
        if ($this->last_daily_credit_at && $this->last_daily_credit_at->isToday()) {
            return false;
        }

        // ==========================================
        // LOGIKA: BATAS MAKSIMAL CREDIT (CAP)
        // ==========================================

        // Tentukan batas maksimal kredit gratis (misal: 15 kredit)
        // Jika saldo user sudah di atas atau sama dengan 15, JANGAN tambah lagi.
        $maxFreeCredits = 15;

        if ($this->credits >= $maxFreeCredits) {
            // Tetap update waktu cek agar tidak diulang terus di hari yang sama,
            // tapi jangan tambah kredit.
            $this->update(['last_daily_credit_at' => now()]);
            return false;
        }

        // 2. Tambah kredit (hanya jika belum mencapai cap)
        $this->addCredits(3);
        $this->update(['last_daily_credit_at' => now()]);

        return true;
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
