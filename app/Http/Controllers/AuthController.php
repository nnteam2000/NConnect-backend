<?php

namespace App\Http\Controllers;

use App\Actions\auth\GoogleCallbackAction;
use App\Actions\auth\Login;
use App\Actions\auth\LoginAction;
use App\Actions\auth\RegisterAction;
use App\Exceptions\EmailNotVerifiedException;
use App\Http\Requests\auth\EmailVerificationRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Jobs\ProcessVerifyEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Nette\Schema\Expect;

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

    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $action($request->validated());

        return response()->json(['message' => 'user logged in', 'user' => auth()->user()], 200);
    }

    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $data = $request->validated();
        $user = $action($data);

        auth()->login($user);
        dispatch(new ProcessVerifyEmail($user));

        return response()->json(['message' => 'verify email',], 200);
    }

    public function logout(): JsonResponse
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['message' => 'Admin logout successfully'], 200);
    }

    public function googleRedirect(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback(GoogleCallbackAction $action)
    {
        $user = $action();
        auth()->login($user);

        return response()->json([
            'message' => 'user logged in',
            'user' => $user
        ]);
    }

}
