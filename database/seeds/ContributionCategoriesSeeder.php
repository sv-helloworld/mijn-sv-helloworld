<?php

use App\ContributionCategory;
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
        ContributionCategory::firstOrCreate([
            'title' => 'Lid',
            'alias' => 'lid',
            'user_category_alias' => 'lid',
        ]);

        ContributionCategory::firstOrCreate([
            'title' => 'Donateur',
            'alias' => 'donateur',
            'user_category_alias' => 'lid',
        ]);
    }
}
