<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\EmailVerificationRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Jobs\ProcessVerifyEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function isAuthenticated(): JsonResponse
    {
        if(auth()->user()->email_verified_at || auth()->user()->google_id) {
            return response()->json(['message' => 'user is authenticated', 'user' => auth()->user()], 200);
        }
        return response()->json(['message' => 'user is not authenticated'], 401);
    }

    public function verification(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully'], 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $remember = $data['remember'] ?? false;

        if(str_contains($data['name'], '@')) {
            $data['email'] = $data['name'];
            unset($data['name']);
        }

        if(auth()->guard('web')->attempt($data, $remember)) {
            if(auth()->user()->email_verified_at) {
                return response()->json(['message' => 'user logged in successfully', 'user'=> auth()->user()], 200);
            }
            dispatch(new ProcessVerifyEmail(auth()->user()));
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
        dispatch(new ProcessVerifyEmail(auth()->user()));

        return response()->json(['message' => 'verify email',], 200);
    }

    public function logout(): JsonResponse
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['message' => 'Admin logout successfully'], 200);
    }
}
