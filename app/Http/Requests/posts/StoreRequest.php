<?php

namespace App\Http\Requests\posts;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:1000|min:2',
            'image' => 'image|max:2024'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('validation.required', ['attribute' => 'content']),
            'content.string' => __('validation.string', ['attribute' => 'content']),
            'content.max' => __('validation.max.string', ['attribute' => 'content', 'max' => 1000]),
            'content.max' => __('validation.min.string', ['attribute' => 'content', 'min' => 2]),
            'image.image' => __('validation.image', ['attribute' => 'image']),
            'image.max' => __('validation.max.file', ['attribute' => 'image', 'max' => 2024]),
        ];
    }
}
