<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'message' => htmlspecialchars($this->message),
        ]);
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string',
        ];
    }
}
