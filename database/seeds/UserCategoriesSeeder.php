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
            'title' => 'Normaal lid',
            'alias' => 'lid',
            'mailchimp_interest_id' => '8f570f4705',
        ]);

        DB::table('user_categories')->insert([
            'title' => 'Donateur',
            'alias' => 'donateur',
            'mailchimp_interest_id' => 'f4125631e0',
        ]);
    }
}
