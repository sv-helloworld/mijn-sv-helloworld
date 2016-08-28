<?php

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
        DB::table('user_categories')->insert([
            [
                'title' => 'Lid',
                'alias' => 'lid',
                'mailchimp_interest_id' => '8f570f4705',
            ],

            [
                'title' => 'Donateur',
                'alias' => 'donateur',
                'mailchimp_interest_id' => 'f4125631e0',
            ],
        ]);
    }
}
