<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'blog_id' => [
                'required',
                'numeric'
            ],
            'published_at' => [
                'date',
                'nullable'
            ],
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
            'translations.*.body' => [
                'array',
                'required'
            ]
        ];
    }
}
