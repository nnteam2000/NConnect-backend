<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'min:3|regex:/^[a-z0-9]+$/|unique:users,id,' . auth()->id(),
            'email' => 'email|unique:users,id,' . auth()->id(),
            'password' => 'regex:/^[a-z0-9]+$/',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email_verified' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => __('validation.min.string', ['attribute' => 'name', 'min' => 3]),
            'name.unique' => __('validation.unique', ['attribute' => 'name']),
            'name.regex' => __('validation.regex', ['attribute' => 'name']),
            'email.email' => __('validation.email', ['attribute' => 'email']),
            'email.unique' => __('validation.unique', ['attribute' => 'email']),
            'password.regex' => __('validation.regex', ['attribute' => 'password']),
            'image.image' => __('validation.image', ['attribute' => 'image']),
            'image.mimes' => __('validation.mimes', ['attribute' => 'image']),
            'image.max' => __('validation.max.file', ['attribute' => 'image', 'max' => 2048]),

        ];
    }
}
