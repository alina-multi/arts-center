<?php

namespace App\Http\Requests;

use App\Rules\UploadedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkImagesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'images.*' => ['required', 'string', new UploadedImage()],
        ];
    }
}
