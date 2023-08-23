<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class UpdatedEmailVerification extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $uniqueFor = 5;

    public function __construct(
        public User $user,
        public string $updatedEmail
    ) {
    }

    public function uniqueId(): string
    {
        return $this->user->id;
    }



    public function content(): Content
    {
        return new Content(
            view: 'mail.feedback',
            with: [
                'greeting' => 'Hello' . ' ' . $this->user->name,
                'thank_you' => 'Please click the button below to verify your email address.',
                'buttonText' => 'Verify Email Address',
                'hint' => 'If you did not create an account, no further action is required.',
                'any_problems' => 'If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:',
                'regards' => 'Regards',
                'url' => env("FRONTEND_URL") . "/api/email/verify/?type=update&user=" . "&newEmail=" . $this->updatedEmail,
            ],
        );
    }
}
