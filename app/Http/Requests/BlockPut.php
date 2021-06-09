<?php

namespace App\Http\Requests;

use App\Rules\BlockData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlockPut extends FormRequest
{
    protected $allowedFields = [
        'text' => ['text', 'align']
    ];

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
            'data.text' => ['string'],
            'data.align' => [Rule::in(['left', 'right', 'center'])]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'data' => $this->filteredData(),
        ]);
    }

    protected function filteredData()
    {
        $filtered = [];
        foreach ($this->data as $key => $value) {
            if (in_array($key, $this->allowedFields[$this->type])) {
                $filtered[$key] = strip_tags($value);
            }
        }
        return $filtered;
    }
}
