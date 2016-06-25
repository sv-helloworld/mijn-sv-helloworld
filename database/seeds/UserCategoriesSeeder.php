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
            ],
        ]);
    }
}
