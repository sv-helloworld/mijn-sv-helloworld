<?php

namespace App\Console\Commands;

use App\Payment;
use App\Subscription;
use Illuminate\Console\Command;
use App\Notifications\PaymentCreated;

class CreateSubscriptionPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:create-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates payments for every subscription that doesn\'t have any payments yet.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscriptions = Subscription::doesntHave('payments')->get();

        if (count($subscriptions) < 1) {
            $this->info('No subscriptions found that don\'t have any payments yet.');

            return 0;
        }

        $this->info(sprintf('Found %d subscription(s) that don\'t have any payments yet.', count($subscriptions)));

        if (! $this->confirm('Do you wish to continue?')) {
            return 1;
        }

        $bar = $this->output->createProgressBar(count($subscriptions));

        foreach ($subscriptions as $subscription) {
            // Create the payment
            $payment = new Payment;
            $payment->amount = $subscription->contribution->amount;
            $payment->description = sprintf('Contributie voor periode %s.', $subscription->contribution->period->name);

            $payment->user()->associate($subscription->user);
            $payment->save();

            // Add payment to the contribution
            $subscription->payments()->save($payment);

            // Send notification to user
            $subscription->user->notify(new PaymentCreated($payment->id));

            $bar->advance();
        }

        $bar->finish();

        $this->info(sprintf('Done creating %d payments.', count($subscriptions)));
    }
}
