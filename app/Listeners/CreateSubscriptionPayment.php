<?php

namespace App\Listeners;

use App\Payment;
use App\Events\SubscriptionApproved;
use App\Notifications\PaymentCreated as PaymentCreatedNotification;

class CreateSubscriptionPayment
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
     * @param  SubscriptionApproved  $event
     * @return void
     */
    public function handle(SubscriptionApproved $event)
    {
        // Create the payment
        $payment = new Payment;
        $payment->amount = $event->amount;
        $payment->description = $event->description;

        $payment->user()->associate($event->user);
        $payment->save();

        // Add payment to the contribution
        $event->subscription->payments()->save($payment);

        // Send notification to user
        $event->user->notify(new PaymentCreatedNotification($payment->id));
    }
}
