<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(UrlGenerator $url)
    {

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $signiture = explode('?', $url)[1] ?? '';
            $url = env("FRONTEND_URL") . "/api/email/verify/" . $notifiable->getKey() . "/" . sha1($notifiable->getEmailForVerification()). '/' . app()->getLocale().'?' . $signiture;
            return (new MailMessage())->view(
                'mail.verification',
                [
            'greeting' => 'Hi '.$notifiable->name,
            'thank_you' => 'Thank you for registering with us. Please click the button below to verify your email address.' ,
            'buttonText' => 'Verify Email',
            'hint' => 'If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:',
            'any_problems' => 'If you did not create an account, no further action is required.',
            'regards' => 'Regards',
            'url'=> $url
            ]
            );
        });

        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }
}
