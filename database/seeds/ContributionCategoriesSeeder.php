<?php

use Illuminate\Database\Seeder;

class ContributionCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contribution_categories')->insert([
            'title' => 'Lid',
            'alias' => 'lid',
        ]);

        DB::table('contribution_categories')->insert([
            'title' => 'Donateur',
            'alias' => 'donateur',
        ]);
    }
}
