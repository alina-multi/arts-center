<?php

namespace App\Http\Requests;

class ProfileRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = [
            ...$rules,
            'name' => ['required', 'string', 'max:191'],
            'current_password' => ['required_with:password', 'current_password'],
            'bios.*' => 'string|nullable',
            'photo' => 'string|nullable'
        ];
        unset ($rules['username']);
        $rules['password'][]= 'sometimes';
        return $rules;
    }
}
