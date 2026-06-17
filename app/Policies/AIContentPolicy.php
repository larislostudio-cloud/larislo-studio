<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AIContent;
use Illuminate\Auth\Access\HandlesAuthorization;

class AIContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AIContent $aIContent): bool
    {
        return $user->id === $aIContent->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AIContent $aIContent): bool
    {
        return $user->id === $aIContent->user_id;
    }
}
