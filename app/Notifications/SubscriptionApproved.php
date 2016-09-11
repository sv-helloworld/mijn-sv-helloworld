<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionApproved extends Notification
{
    use Queueable;

    /**
     * The subscription id.
     *
     * @var int
     */
    public $subscription_id;

    /**
     * The subscription period name.
     *
     * @var int
     */
    public $period_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription_id, $period_name)
    {
        $this->subscription_id = $subscription_id;
        $this->period_name = $period_name;
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
            ->subject('Je inschrijving is goedgekeurd!')
            ->line(sprintf('Goed nieuws! Je inschrijving voor periode \'%s\' is goedgekeurd.', $this->period_name))
            ->line([
                'Over enkele momenten ontvang je van ons een e-mail met de melding dat er een betaling voor je klaarstaat.',
                'Dit is de betaling voor de contributie van deze periode.',
                'Wanneer je de betaling hebt afgerond zal je inschrijving definitief worden gemaakt.',
            ])
            ->action('Bekijk inschrijving', route('subscription.show', $this->subscription_id))
            ->line('Bedankt voor je inschrijving!');
    }
}
