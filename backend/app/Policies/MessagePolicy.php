<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return false;
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
    public function update(User $user, Message $message): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return ($message->user_id === $user->id) && ($message->created_at->diffInMinutes(now()) < 10);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return $message->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Message $message): bool
    {
        if ($user->role === UserRoles::SuperAdmin) {
            return true;
        }
        return $message->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Message $message): bool
    {
        return false;
    }
}
