<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SingleOwnerPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $model)
    {
        if ($model->user_id === $user->id) {
            return true;
        }
        return $user->isAdmin();
    }

    public function delete(User $user, $model)
    {
        return $this->update($user, $model);
    }

    public function forceDelete(User $user, $model)
    {
        return $this->update($user, $model);
    }

    public function create()
    {
        return true;
    }

    public function viewAny()
    {
        return true;
    }

    public function view()
    {
        return true;
    }

    public function restore(User $user)
    {
        return $user->isAdmin();
    }
}
