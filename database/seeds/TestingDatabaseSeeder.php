<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

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
