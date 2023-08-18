<?php

namespace App\Exceptions;

use Exception;

class EmailNotVerifiedException extends Exception
{
    public function render($request)
    {
        return response()->json(['email_not_verified' => 'Please verify your email'], 401);
    }

    public function report()
    {
        return logger()->error('Email not verified');
    }
}
