<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentCreated extends Notification
{
    /**
     * The payment id.
     *
     * @var int
     */
    public $payment_id;

    /**
     * Create a new notification instance.
     *
     * @param  int  $payment_id
     * @return void
     */
    public function __construct($payment_id)
    {
        $this->payment_id = $payment_id;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Er staat een nieuwe betaling voor je klaar')
            ->line([
                'Er staat een nieuwe betaling voor je klaar.',
                'Druk op de knop hieronder om naar de details van de betaling te gaan:',
            ])
            ->action('Naar betaling', route('payment.show', $this->payment_id))
            ->line('Als je de betaling reeds hebt voldaan kun je deze e-mail negeren.');
    }
}
