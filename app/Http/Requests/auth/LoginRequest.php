<?php

namespace App\Http\Requests\auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user' => 'required|min:3',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => __('auth.failed'),
            'user.min' => __('validation.min.string', ['attribute' => 'user', 'min' => 3]),
            'password.required' => __('validation.required', ['attribute' => 'password']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(['message'=> "invalid data",'errors'=> $validator->errors()->messages()], 422)
        );
    }
}
