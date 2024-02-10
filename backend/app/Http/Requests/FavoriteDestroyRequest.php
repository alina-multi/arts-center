<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteDestroyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'work_id' => [
                'required',
                'integer',
                'exists:works,id'
            ],
        ];
    }
}
