<?php

namespace App\Http\Requests;

use App\Rules\ReservedWords;
use App\Rules\Username;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Convert all rules to array syntax
        return [
            'username' => [
                'required', 'string', 'min:5', 'max:191', 'profane',
                new Username(),
                new ReservedWords(),
                Rule::unique('users', 'username')->ignore($this?->user()?->id),
            ],
            'email' => [
                'required', 'email', 'max:191',
                Rule::unique('users', 'email')->ignore($this?->user()?->id),
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
            'country' => ['string', 'min:2', 'max:2', 'nullable'],
        ];
    }
}
