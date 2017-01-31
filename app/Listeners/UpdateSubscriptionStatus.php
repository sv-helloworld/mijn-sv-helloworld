<?php

namespace App\Listeners;

use App\Subscription;
use App\Events\PaymentCompleted;
use App\Notifications\SubscriptionConfirmed as SubscriptionConfirmedNotification;

class UpdateSubscriptionStatus
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
        $subscription = $event->payment->payable;

        if (! $subscription instanceof Subscription) {
            return;
        }

        // The total paid amount isn't equal to the contribution amount
        if ($subscription->contribution->amount > $event->payment->amount) {
            return;
        }

        $subscription->confirmed_at = time();

        // Set user category
        $event->payment->user->user_category_alias = $subscription->contribution->contribution_category->user_category_alias;
        $event->payment->user->save();

        if ($subscription->touch()) {
            // Send notification to user
            $event->payment->user->notify(new SubscriptionConfirmedNotification($subscription->id));
        }
    }
}
