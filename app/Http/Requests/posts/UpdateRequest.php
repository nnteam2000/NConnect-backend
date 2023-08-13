<?php

namespace App\Http\Requests\posts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->id === $this->post->user_id;
    }

    public function rules(): array
    {
        return [
            'content' => 'string|max:1000|min:2',
            'image' => 'image|max:2024'
        ];
    }

    public function messages()
    {
        return [
            'content.string' => __('validation.string', ['attribute' => 'content']),
            'content.max' => __('validation.max.string', ['attribute' => 'content', 'max' => 1000]),
            'content.max' => __('validation.min.string', ['attribute' => 'content', 'min' => 2]),
            'image.image' => __('validation.image', ['attribute' => 'image']),
            'image.max' => __('validation.max.file', ['attribute' => 'image', 'max' => 2024]),
        ];
    }
}
