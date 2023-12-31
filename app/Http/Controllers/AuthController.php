<?php

namespace App\Http\Controllers;

use App\Actions\auth\GoogleCallbackAction;
use App\Actions\auth\LoginAction;
use App\Actions\auth\RegisterAction;
use App\Http\Requests\auth\EmailVerificationRequest;
use App\Http\Requests\auth\ForgetRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\ResetRequest;
use App\Http\Requests\auth\UpdateRequest;
use App\Jobs\ProcessVerifyEmail;
use App\Mail\UpdatedEmailVerification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

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
        return response()->json(['message' => 'user logged out successfully'], 200);
    }

    public function forget(ForgetRequest $request): JsonResponse
    {
        $status =  Password::sendResetLink($request->validated());

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'reset link sent'], 200)
            : response()->json(['message' => 'reset link not sent'], 400);
    }

    public function reset(ResetRequest $request): JsonResponse
    {
        $status  = Password::reset($request->validated(), function ($user) use ($request) {
            $user->password = $request->password;
            $user->setRememberToken(\Illuminate\Support\Str::random(60));

            $user->save();
        });

        return $status === Password::PASSWORD_RESET ?
            response()->json(['message' => 'password reset successfully'], 200) :
            response()->json(['message' => 'password reset failed'], 400);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        if(isset($data['email_verified'], $data['email'])) {
            // make this more secure
            // anyone who will provide email_verified = true and email = any email will be able to update the email
            auth()->user()->update(['email_verified_at' => now(), 'email' => $data['email']]);
            return response()->json(['message' => 'email updated succesfully'], 200);
        }

        unset($data['email_verified']);

        if(empty($data)) {
            return response()->json(['message' => 'no data to update'], 400);
        }

        if($request->hasFile('image')) {
            $data['image'] =  env('APP_URL') . '/storage/' . $request->file('image')->store('avatars');
        }

        if($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if($request->has('email')) {
            $data['email_verified_at'] =  null;
            Mail::to($data['email'])->send(new UpdatedEmailVerification(
                auth()->user(),
                $data['email']
            ));
            unset($data['email']);
        }

        auth()->user()->update($data);

        return response()->json(
            [
                'message' => 'user updated successfully. If email change was requested please verify the email we sent you for changes to persist'
            ],
            200
        );
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
