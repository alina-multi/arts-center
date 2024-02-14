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
            'title' => [
                'required',
                'string',
                'min:5',
                'max:191'
            ],
            'published_at' => [
                'date',
                'nullable'
            ],
            'language' => [
                'required',
                Rule::in(config('app.languages'))
            ],
            'image_id' => [
                'nullable',
                'exists:images,id'
            ],
            'body' => [
                'array'
            ],
            'body.*.type' => [
                'required',
                Rule::in(['text', 'image', 'work'])
            ],
            'body.*.image_id' => [
                'integer',
                'nullable',
                'required_if:body.*.type,image',
                'exists:images,id'
            ],
            'body.*.text' => [
                'string',
                'nullable',
                'required_if:body.*.type,text',
            ],
            'body.*.works' => [
                'array',
                'nullable',
                'required_if:body.*.type,work',
            ],
            'body.*.works.*' => [
                'integer',
                'exists:works,id',
            ]
        ];
    }
}
