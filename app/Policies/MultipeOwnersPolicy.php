<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MultipeOwnersPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $model)
    {
        foreach ($model->owners as $owner) {
            if ($owner->id == $user->id) {
                return true;
            }
        }
    }
}
