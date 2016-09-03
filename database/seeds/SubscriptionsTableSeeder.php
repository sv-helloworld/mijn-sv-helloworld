<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Subscription::class, 5)->create()->each(function($s) {
            $s->save();
        });

        factory(App\Subscription::class, 'early_bird', 5)->create()->each(function($s) {
            $s->save();
        });
    }
}
