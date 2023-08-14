<?php

namespace App\Http\Requests\comments;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer|exists:posts,id',
            'parent_id' => 'integer|exists:comments,id',
            'content' => 'required|string|max:1000|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => __('validation.required', ['attribute' => 'post_id']),
            'post_id.integer' => __('validation.integer', ['attribute' => 'parent_id']),
            'post_id.exists' => __('validation.exists', ['attribute' => 'post_id']),
            'parent_id.exists' => __('validation.exists', ['attribute' => 'parent_id']),
            'content.required' => __('validation.required', ['attribute' => 'content']),
            'content.string' => __('validation.string', ['attribute' => 'content']),
            'content.max' => __('validation.max.string', ['attribute' => 'content', 'max' => 1000]),
            'content.min' => __('validation.min.string', ['attribute' => 'content', 'min' => 1]),
        ];
    }
}
