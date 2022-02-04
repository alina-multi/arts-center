<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'translations' => [
                'required',
                'array'
            ],
            'translations.*.language' => [
                'required',
                'distinct',
                Rule::in(config('app.languages'))
            ],
            'translations.*.title' => [
                'required'
            ],
            'translations.*.about' => [
                'array',
                'required'
            ]
        ];
    }
}
