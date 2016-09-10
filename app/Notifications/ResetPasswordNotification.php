<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->subject('Wachtwoord opnieuw instellen')
            ->line([
                'Je ontvangt deze mail omdat we een wachtwoord reset verzoek hebben gekregen voor jouw account.',
                'Klik op de knop hieronder om je wachtwoord opnieuw in te stellen:',
            ])
            ->action('Wachtwoord opnieuw instellen', route('account.password.show', $this->token))
            ->line('Als je dit verzoek niet zelf hebt ingediend hoef je geen verdere actie te ondernemen.');
    }
}
