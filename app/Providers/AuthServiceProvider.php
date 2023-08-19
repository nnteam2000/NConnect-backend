<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Comment;
use App\Models\Post;
use App\Policies\AuthorPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Comment::class => AuthorPolicy::class,
        Post::class => AuthorPolicy::class,
    ];

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {

            $signiture = explode('?', $url)[1] ?? '';
            $url = env("FRONTEND_URL") . "/api/email/verify/" . $notifiable->getKey() . "/" . sha1($notifiable->getEmailForVerification()). '/' . app()->getLocale().'?' . $signiture;

            return (new MailMessage())->view(
                'mail.feedback',
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
    }
}
