<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteStoreRequest extends FavoriteDestroyRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'folder_title' => [
                'required_without:folder_id',
                'string',
                'max:191',
                Rule::unique('favorite_folders', 'title')
                    ->where(fn(Builder $query) => $query->where('user_id', $this->user()->id))
            ],
            'folder_id' => [
                'required_without:folder_title',
                'integer',
                'exists:favorite_folders,id'
            ],
        ];
    }
}
