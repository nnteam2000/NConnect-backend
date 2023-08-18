<?php

namespace App\Actions\auth;

use App\Models\User;

class RegisterAction
{
    public function __invoke(array $data): User
    {

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return $user;
    }
}
