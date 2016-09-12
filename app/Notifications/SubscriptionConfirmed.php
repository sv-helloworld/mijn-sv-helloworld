<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionConfirmed extends Notification
{
    use Queueable;

    /**
     * The subscription id.
     *
     * @var int
     */
    public $subscription_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription_id)
    {
        $this->subscription_id = $subscription_id;
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
            ->subject('Bedankt voor je inschrijving!')
            ->line([
                'Bedankt voor je inschrijving, je bent nu succesvol ingeschreven als lid van Studievereniging "Hello World".',
                'Als lid van de studievereniging zul je, gedurende de gehele periode waarin de contributie geldig is, ',
                'korting krijgen op activiteiten die we gaan organiseren!',
            ])
            ->line('Klik op de knop hieronder om naar de details van je inschrijving te gaan:')
            ->action('Bekijk inschrijving', route('subscription.show', $this->subscription_id))
            ->line('Nogmaals bedankt voor je inschrijving, we zien je graag bij het eerstvolgende activiteit!');
    }
}
