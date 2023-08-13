<?php

namespace App\Http\Requests\posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->id === $this->post->user_id;
    }
}
