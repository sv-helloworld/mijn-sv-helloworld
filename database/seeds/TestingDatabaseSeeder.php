<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserCategoriesSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(ActivityEntriesTableSeeder::class);

        Model::reguard();
    }
}
