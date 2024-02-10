<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validate($attribute, $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            $fail('a-Z 0-9 _')->translate();
        }
    }
}
