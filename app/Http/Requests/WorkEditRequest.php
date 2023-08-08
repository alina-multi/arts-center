<?php

namespace App\Http\Requests;

use App\Enums\TagTypes;
use App\Rules\AspectRatio;
use App\Rules\TagType;
use App\Rules\UploadedImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkEditRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags($this->title ?? ''),
            'description' => strip_tags($this->description ?? ''),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'language' => [
                'required',
                Rule::in(config('app.languages'))
            ],
            'main' => ['string', new UploadedImage()],
            'more.*' => ['string', new UploadedImage()],
            'title' => ['string', 'required', 'min:4', 'max:40'],
            'description' => ['string'],
            'category' => ['required', 'array'],
            'category.*' => ['numeric', 'exists:tags,id', new TagType(TagTypes::CATEGORY)],
            'crop.x' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.y' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.width' => ['numeric', 'required_with:crop', 'min:0'],
            'crop.height' => ['numeric', 'required_with:crop', 'min:0', new AspectRatio('crop.width', 4 / 3)],
        ];
    }
}
