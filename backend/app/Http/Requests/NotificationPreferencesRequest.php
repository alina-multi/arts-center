<?php

namespace App\Http\Requests;

use App\Enums\{NotificationChannels, NotificationTypes};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationPreferencesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'preferences' => ['array'],
            'preferences.*.type' => ['required', Rule::enum(NotificationTypes::class)],
            'preferences.*.channel' => ['required', Rule::enum(NotificationChannels::class)],
        ];
    }
}
