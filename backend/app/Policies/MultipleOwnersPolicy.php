<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MultipleOwnersPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $model)
    {
        foreach ($model->owners as $owner) {
            if ($owner->id == $user->id) {
                return true;
            }
        }
        return $user->role === UserRoles::SuperAdmin;
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
        return $user->role === UserRoles::SuperAdmin;
    }
}
