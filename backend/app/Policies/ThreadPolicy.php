<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Thread;
use App\Models\User;

class ThreadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Thread $thread): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return $this->userIsParticipant($user, $thread);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Thread $thread): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return $this->userIsParticipant($user, $thread);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Thread $thread): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Thread $thread): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Thread $thread): bool
    {
        return false;
    }

    private function userIsParticipant(User $user, Thread $thread): bool
    {
        return $thread->participants()->where('user_id', $user->id)->whereNotNull('approved_at')->exists();
    }
}
