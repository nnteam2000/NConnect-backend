<?php

namespace App\Actions\auth;

use App\Exceptions\JsonException;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleCallbackAction
{
    public function __invoke(): User
    {
        $googleUser =  Socialite::driver('google')->stateless()->user();
        $google_id = $googleUser->getId();

        $user = User::firstWhere(['email'=> $googleUser->getEmail()]);

        if($user && $user->google_id === $google_id) {
            return $user;
        } elseif($user && $user->google_id !== $google_id) {
            throw new JsonException(['details'=>['email' => __('validation.exists', ['attribute'=> 'email'])]], 401);
        }

        $user = User::create(
            [
                    'google_id' => $google_id,
                    'email' => $googleUser->getEmail(),
                    'username' => $googleUser->name ?? $googleUser->getNickname(),
                    'password' => null,
                    'image' => $googleUser->getAvatar(),
                ]
        );

        return $user;
    }
}
