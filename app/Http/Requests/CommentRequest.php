<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'text' => strip_tags($this->input('text'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'commentable_id' => 'required|integer',
            'commentable_type' => [
                'required',
                Rule::in(array_keys(Relation::morphMap())),
            ],
            'comment_id' => 'integer|exists:comments,id',
            'depth' => 'integer',
            'text' => 'required|string'
        ];
    }
}
