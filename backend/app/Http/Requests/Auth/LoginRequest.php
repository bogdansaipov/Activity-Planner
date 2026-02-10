<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'username' => 'required|string',
            'password' => 'required|string'
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
            'username.required' => 'The Username field is required',
            'password.required' => 'The Password is required'
        ];   
    }
}