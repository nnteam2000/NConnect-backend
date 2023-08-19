<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'regex:/^[a-z0-9]+$/|exists:users,name',
            'email' => 'email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => __('validation.regex', ['attribute' => 'name']),
            'name.exists' => __('validation.exists', ['attribute' => 'name']),
            'email.exists' => __('validation.exists', ['attribute' => 'email']),
        ];
    }
}
