<?php

namespace App\Listeners;

use App\Events\SubscriptionApproved;

class CreatePayment
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
        $event->user->notify(new PaymentCreated($payment_id));
    }
}
