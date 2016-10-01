<?php

namespace App\Events;

use App\ActivityEntry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserAppliedForActivity
{
    use InteractsWithSockets, SerializesModels;

    /**
     * The activity entry where the payment belongs to.
     *
     * @var ActivityEntry
     */
    public $activity_entry;

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
     * @param ActivityEntry $activity_entry The user's activity entry.
     * @return void
     */
    public function __construct(ActivityEntry $activity_entry)
    {
        $this->activity_entry = $activity_entry;
        $this->user = $activity_entry->user;
        $this->amount = $activity_entry->activity_price->amount;
        $this->description = sprintf('Kosten activiteit: %s.', $activity_entry->activity->title);
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
