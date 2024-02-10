<?php

namespace App\Http\Requests;

use App\Enums\FeedbackCategory;
use App\Enums\FeedbackType;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFeedbackRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'body' => strip_tags($this->input('body')),
            'title' => strip_tags($this->input('title')),
        ]);
    }
    public function rules(): array
    {
        return [
            'language' => [
                'required',
                Rule::in(config('app.languages'))
            ],
            'title' => [
                'required_unless:type,complaint',
                'string',
            ],
            'body' => [
                'string',
                Rule::requiredIf($this->input('type') !== 'complaint'
                    || $this->input('category') === FeedbackCategory::other)
            ],
            'type' => ['required', Rule::enum(FeedbackType::class)],
            'category' => [
                'required_if:type,complaint',
                Rule::enum(FeedbackCategory::class)
            ],
            'feedbackable_id' => [
                'required_if:type,complaint',
            ],
            'feedbackable_type' => [
                'required_if:type,complaint',
                Rule::in(array_keys(Relation::morphMap()))
            ],
        ];
    }
}
