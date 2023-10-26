<?php

namespace App\Http\Requests;

use App\Enums\TransactionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class CreateCheckoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'int'],
            'type' => [
                'required',
                Rule::enum(TransactionTypes::class)
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function (Builder $query) {
                    return $query->whereNotNull('verified_at');
                })
            ],
            'username' => [
                'required', 'string'
            ]
        ];
    }
}
