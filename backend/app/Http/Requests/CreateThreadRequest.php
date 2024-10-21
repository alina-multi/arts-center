<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateThreadRequest extends UpdateThreadRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return [
            ...$rules,
            'participants' => ['array', 'required', 'min:1'],
            'participants.*' => ['integer', 'exists:users,id'],
        ];
    }
}
