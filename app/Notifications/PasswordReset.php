<?php

declare(strict_types=1);

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class PasswordReset extends Notification
{
    use Queueable;

    /**
     * Get the notification’s delivery channels.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        $passwordReset = DB::table('password_resets')
            ->where('email', $user->email)
            ->first();

        return (new MailMessage())
            ->markdown('mail.passwords.reset', [
                'user' => $user,
                'token' => $passwordReset->token,
            ]);
    }
}
