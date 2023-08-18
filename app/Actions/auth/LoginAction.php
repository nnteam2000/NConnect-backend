<?php

namespace App\Actions\auth;

use App\Exceptions\EmailNotVerifiedException;
use App\Jobs\ProcessVerifyEmail;
use Exception;

class LoginAction
{
    public function __invoke(array $data): bool
    {
        $remember = $data['remember'] ?? false;

        if(str_contains($data['name'], '@')) {
            $data['email'] = $data['name'];
            unset($data['name']);
        }

        if(auth()->guard('web')->attempt($data, $remember)) {
            if(auth()->user()->email_verified_at) {
                return true;
            }
            dispatch(new ProcessVerifyEmail(auth()->user()));
            throw new EmailNotVerifiedException();
        }


        throw new Exception(__('auth.failed'), 401);
        return false;
    }
}
