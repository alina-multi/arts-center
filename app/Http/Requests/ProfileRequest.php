<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            ...parent::rules(),
            'name' => ['required', 'string', 'max:191'],
            'current_password' => ['required_with:password', 'current_password'],
            'biography.*' => 'string|nullable',
        ];
        $rules['password'][] = 'sometimes';
        $rules['email'][] = 'sometimes';
        return $rules;
    }
}
