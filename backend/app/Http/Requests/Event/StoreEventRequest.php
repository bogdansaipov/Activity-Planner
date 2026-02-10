<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:1|max:1440',
            'remind_before_minutes' => 'nullable|integer|min:0|max:1440',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {   
        return [
            'title.required' => 'The Event title field is required',
            'scheduled_at.required' => 'The scheduled_at field is required'
        ];
    }
}