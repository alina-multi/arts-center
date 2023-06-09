<?php

namespace App\Http\Requests;

use App\Rules\UploadedImage;
use Illuminate\Foundation\Http\FormRequest;

class DraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !empty($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'main' => ['required', 'string', new UploadedImage()],
            'more.*' => ['string', new UploadedImage()],
        ];
    }
}
