<?php

namespace App\Exceptions;

use Exception;

class JsonException extends Exception
{
    public function __construct(public $body = [], public $code = 422)
    {
    }

    public function render()
    {
        return response()->json(['message'=> $this->body], $this->code);
    }
}
