<?php

namespace App\Listeners;

use App\ActivityEntry;
use App\Events\PaymentCompleted;
use App\Notifications\ActivityEntryConfirmed as ActivityEntryConfirmedNotification;

class UpdateActivityEntryStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentCompleted  $event
     * @return void
     */
    public function handle(PaymentCompleted $event)
    {
        $activity_entry = $event->payment->payable;

        if (! $activity_entry instanceof ActivityEntry) {
            return;
        }

        // The total paid amount isn't equal to the contribution amount
        if ($activity_entry->amount > $event->payment->amount) {
            return;
        }

        $activity_entry->confirmed_at = time();

        if ($activity_entry->touch()) {
            // Send notification to user
            $event->payment->user->notify(new ActivityEntryConfirmedNotification($activity_entry->id, $activity_entry->activity->title));
        }
    }
}
