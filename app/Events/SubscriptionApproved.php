<?php

namespace App\Events;

use App\Subscription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class SubscriptionApproved
{
    use InteractsWithSockets, SerializesModels;

    /**
     * The subscription where the payment belongs to.
     *
     * @var Subscription
     */
    public $subscription;

    /**
     * The user that is responsible for the payment.
     *
     * @var User
     */
    public $user;

    /**
     * The amount of the payment.
     *
     * @var float
     */
    public $amount;

    /**
     * The description of the payment.
     *
     * @var string
     */
    public $description;

    /**
     * Create a new event instance.
     *
     * @param Subscription $subscription The subscription that has been approved.
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->user = $subscription->user;
        $this->amount = $subscription->contribution->amount;
        $this->description = sprintf('Contributie voor periode %s.', $subscription->contribution->period->name);
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
