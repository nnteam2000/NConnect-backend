<?php

namespace App\Exceptions;

use App\Jobs\ProcessVerifyEmail;
use Exception;

class EmailNotVerifiedException extends Exception
{
    public function render($request)
    {
        dispatch(new ProcessVerifyEmail(auth()->user()));
        return response()->json(['email_not_verified' => 'Please verify your email'], 401);
    }

    public function report()
    {
        return false;
    }
}
