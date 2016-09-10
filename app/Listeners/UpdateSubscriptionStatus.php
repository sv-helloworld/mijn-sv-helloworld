<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SubscriptionConfirmed;

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

        $total = 0;

        $payments = $subscription->payments->each(function ($payment) {
            if ($payment->paid()) {
                $total =+ $payment->amount;
            }
        });

        // The total paid amount isn't equal to the contribution amount
        if ($subscription->contribution->amount > $total) {
            return;
        }

        $subscription->confirmed_at = time();

        if ($subscription->touch()) {
            // Send notification to user
            $event->payment->user->notify(new SubscriptionConfirmed($subscription->id));
        }
    }
}
