<?php

use Illuminate\Database\Seeder;

class ActivityEntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ActivityEntry::class, 5)->create();
    }
}
