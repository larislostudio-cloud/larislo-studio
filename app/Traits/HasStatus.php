<?php

namespace App\Traits;

trait HasStatus
{
    /**
     * Cek apakah record memiliki status tertentu.
     */
    public function hasStatus(string $status): bool
    {
        return $this->status === $status;
    }

    /**
     * Update status record.
     */
    public function markAs(string $status): bool
    {
        return $this->update(['status' => $status]);
    }

    /**
     * Scope: Ambil hanya record yang published.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: Ambil hanya record yang draft.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
