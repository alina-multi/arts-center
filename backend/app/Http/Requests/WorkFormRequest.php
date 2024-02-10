<?php

namespace App\Http\Requests;

use App\Enums\TagTypes;
use App\Rules\AspectRatio;
use App\Rules\TagType;
use App\Rules\UploadedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkFormRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (is_array($this->titles)) {
            $stripedTitles = [];
            foreach ($this->titles as $title) {
                $stripedTitles[] = [
                    'title' => strip_tags($title['title']),
                    'language' => $title['language'] ?? '',
                    'description' => strip_tags($title['description']?? '')
                ];
            }
            $this->merge([
                'titles' => $stripedTitles
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'titles' => ['required'],
            'titles.*.title' => ['string', 'required', 'min:4', 'max:40'],
            'titles.*.language' => [
                'required_with:titles.*.title',
                Rule::in(config('app.languages'))
            ],
            'titles.*.description' => ['string'],
            'category' => ['required', 'array'],
            'category.*' => ['numeric', 'exists:tags,id', new TagType(TagTypes::CATEGORY)],
        ];
    }
}
