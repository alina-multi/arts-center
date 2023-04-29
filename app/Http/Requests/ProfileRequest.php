<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'username' => 'required|string|min:5|max:191|unique:users,username,' . $this->user()->id,
            'email' => 'sometimes|required|email|max:191|unique:users,email,' . $this->user()->id,
            'password' => ['sometimes', 'required', 'confirmed', Password::defaults()],
            'current_password' => 'required_with:password|current_password',
            'country' => 'string|min:2|max:2|nullable',
            'biography.*' => 'string|nullable',
        ];
    }
}
