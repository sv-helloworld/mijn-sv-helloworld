<?php

namespace App\Listeners;

use App\Payment;
use App\Notifications\PaymentCreated;
use App\Events\UserAppliedForActivity;

class CreateActivityEntryPayment
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
     * @param  UserAppliedForActivity  $event
     * @return void
     */
    public function handle(UserAppliedForActivity $event)
    {
        // Create the payment
        $payment = new Payment;
        $payment->amount = $event->amount;
        $payment->description = $event->description;

        $payment->user()->associate($event->user);
        $payment->save();

        // Add payment to the activity
        $event->activity_entry->payments()->save($payment);

        // Send notification to user
        $event->user->notify(new PaymentCreated($payment->id));
    }
}
