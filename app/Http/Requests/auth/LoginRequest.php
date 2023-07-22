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
            'name' => 'required|min:3',
            'password' => 'required',
            "remember" => "boolean"
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('auth.failed'),
            'name.min' =>__('auth.failed'),
            'password.required' => __('auth.failed'),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(['message'=> "invalid data",'errors'=> $validator->errors()->messages()], 422)
        );
    }
}
