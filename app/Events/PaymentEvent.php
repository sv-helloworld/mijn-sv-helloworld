<?php

namespace App\Events;

abstract class PaymentEvent
{
    /**
     * The user that is responsible for the payment.
     *
     * @var User
     */
    public $user;

    /**
     * The amount of the payment
     *
     * @var float
     */
    public $amount;

    /**
     * The description of the payment
     *
     * @var string
     */
    public $description;
}
