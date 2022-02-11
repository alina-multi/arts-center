<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MultipeOwnersPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $model)
    {
        $owners = $model->owners()->toSql();
        foreach ($model->owners as $owner) {
            if ($owner->id == $user->id) {
                return true;
            }
        }
        return $user->isAdmin();
    }

    public function delete(User $user, $model)
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
