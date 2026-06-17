<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ScheduledPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScheduledPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ScheduledPost $scheduledPost): bool
    {
        return $user->id === $scheduledPost->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ScheduledPost $scheduledPost): bool
    {
        // Hanya pemilik post yang bisa update, DAN statusnya masih draft/scheduled
        return $user->id === $scheduledPost->user_id && $scheduledPost->status !== 'published';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScheduledPost $scheduledPost): bool
    {
        return $user->id === $scheduledPost->user_id;
    }
}
