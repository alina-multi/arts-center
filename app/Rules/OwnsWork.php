<?php

namespace App\Rules;

use App\Models\Work;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class OwnsWork implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_id = Auth::id();
        $work = Work::where('id', $value)->first();
        foreach ($work->owners as $owner) {
            if ($owner->id === $user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "You don't own this work, you silly hacker :)";
    }
}
