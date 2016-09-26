<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UpdateUserSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the validity of the subscription for every user.';

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
        $users = User::all();

        $this->info(sprintf('Checking the validity of subscriptions for %d users.', count($users)));

        foreach ($users as $user) {
            $subscriptions = $user->subscriptions()->get();

            $this->info(sprintf('%s has %d subscription(s).', $user->full_name(), count($subscriptions)));

            foreach ($subscriptions as $subscription) {
                if ($subscription->valid()) {
                    $this->info(sprintf('Found valid subscription for user %s in period %s.', $user->full_name(), $subscription->contribution->period->name));

                    // Valid subscription found, set user category to the user category that belongs to the subscription.
                    $user->user_category_alias = $subscription->contribution->contribution_category->user_category_alias;
                    $user->save();

                    continue 2;
                }
            }

            $this->info(sprintf('No valid subscriptions found for user %.', $user->full_name()));

            // No valid subscription found, set user category to 'geen-lid'.
            $user->user_category_alias = 'geen-lid';
            $user->save();
        }
    }
}
