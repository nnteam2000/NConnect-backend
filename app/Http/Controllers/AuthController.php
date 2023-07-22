<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $remember = $data['remember'] ?? false;

        if(auth()->attempt($data, $remember)) {
            if(auth()->user()->hasVerifiedEmail()) {
                return response()->json(['message' => 'Admin login successfully'], 200);
            }
            auth()->user()->sendEmailVerificationNotification();
            return response()->json(['email_not_verified' => 'Please verify your email'], 401);
        }

        return response()->json(['message' => __('auth.failed')], 401);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if(str_contains($data['name'], '@')) {
            $data['email'] = $data['name'];
            unset($data['name']);
        }
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        auth()->login($user);
        event(new Registered($user));

        return response()->json(['message' => 'verify email'], 200);
    }
}
