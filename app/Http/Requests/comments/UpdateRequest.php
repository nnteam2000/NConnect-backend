<?php

namespace App\Http\Requests\comments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->id() === $this->comment->user_id;
    }

    public function rules(): array
    {
        return [
           'content' => 'required|string|max:999|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => __('comments.content_required', ['attribute' => 'content']),
            'content.string' => __('comments.content_string', ['attribute' => 'content']),
            'content.max' => __('comments.content_max', ['attribute' => 'content', 'max' => 999]),
            'content.min' => __('comments.content_min', ['attribute' => 'content', 'min' => 1]),
        ] ;
    }
}
