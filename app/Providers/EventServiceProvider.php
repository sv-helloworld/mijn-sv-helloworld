<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserCreatedOrChanged' => [
            'App\Listeners\SubscribeToMailchimpList',
        ],

        'App\Events\UserDeleted' => [
            'App\Listeners\UnsubscribeFromMailchimpList',
        ],

        'App\Events\SubscriptionApproved' => [
            'App\Listeners\SendSubscriptionApprovedNotification',
            'App\Listeners\CreateSubscriptionPayment',
        ],

        'App\Events\UserAppliedForActivity' => [
            'App\Listeners\CreateActivityEntryPayment',
        ],

        'App\Events\PaymentCompleted' => [
            'App\Listeners\UpdateActivityEntryStatus',
            'App\Listeners\UpdateSubscriptionStatus',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
