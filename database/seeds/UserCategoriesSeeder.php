<?php

use App\UserCategory;
use Illuminate\Database\Seeder;

class UserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCategory::firstOrCreate([
            'title' => 'Lid',
            'alias' => 'lid',
            'mailchimp_interest_id' => '8f570f4705',
        ]);

        UserCategory::firstOrCreate([
            'title' => 'Geen lid',
            'alias' => 'geen-lid',
        ]);

        UserCategory::firstOrCreate([
            'title' => 'Donateur',
            'alias' => 'donateur',
            'mailchimp_interest_id' => 'f4125631e0',
        ]);
    }
}
