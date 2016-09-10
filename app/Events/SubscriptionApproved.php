<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Subscription;

class SubscriptionApproved extends PaymentEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Subscription $subscription The subscription that has been approved.
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->user = $subscription->user;
        $this->amount = $subscription->contribution->amount;
        $this->description = "Betaling contributie voor periode '" . $subscription->contribution->period->name . "'.";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
