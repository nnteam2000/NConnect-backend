<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $uniqueFor = 5;
    public $tries = 3;
    public $timeout = 60;


    public function __construct(protected string $url)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->view(
            'mail.feedback',
            [
                'thank_you' => 'You are receiving this email because we received a password reset request for your account.',
                'buttonText' => 'Reset Password',
                'hint' => 'If you did not request a password reset, no further action is required.',
                'any_problems' => 'If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:',
                'regards' => 'Regards,',
                'url' => $this->url,
            ],
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}


