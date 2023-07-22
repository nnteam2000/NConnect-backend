<?php

namespace App\Http\Requests\auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|unique:users|regex:/^[a-z0-9]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|regex:/^[a-z0-9]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('auth.failed'),
            'name.min' => __('validation.min.string', ['attribute' => 'name', 'min' => 3]),
            'name.unique' => __('validation.unique', ['attribute' => 'name']),
            'name.regex' => __('validation.regex', ['attribute' => 'name']),
            'email.required' => __('validation.required', ['attribute' => 'email']),
            'email.email' => __('validation.email', ['attribute' => 'email']),
            'email.unique' => __('validation.unique', ['attribute' => 'email']),
            'password.required' => __('validation.required', ['attribute' => 'password']),
            'password.regex' => __('validation.regex', ['attribute' => 'password']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(['message'=> "invalid data",'errors'=> $validator->errors()->messages()], 422)
        );
    }
}
