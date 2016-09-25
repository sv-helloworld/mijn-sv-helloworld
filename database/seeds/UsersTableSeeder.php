<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Voorbeeld',
            'last_name' => 'Admin',
            'email' => 'admin@hz.nl',
            'password' => bcrypt('Admin123'),
            'account_type' => 'admin',
            'activated' => true,
            'verified' => true,
            'address' => 'Voorbeeldstraat 123',
            'zip_code' => '1234 AB',
            'city' => 'Voorbeeldstad',
        ]);

        DB::table('users')->insert([
            'first_name' => 'Voorbeeld',
            'last_name' => 'Gebruiker',
            'email' => 'gebruiker@hz.nl',
            'password' => bcrypt('Gebruiker123'),
            'account_type' => 'user',
            'activated' => true,
            'verified' => true,
            'address' => 'Voorbeeldstraat 123',
            'zip_code' => '1234 AB',
            'city' => 'Voorbeeldstad',
        ]);

        DB::table('users')->insert([
            'first_name' => 'Voorbeeld',
            'last_name' => 'Lid',
            'email' => 'lid@hz.nl',
            'password' => bcrypt('Lid123'),
            'account_type' => 'user',
            'user_category_alias' => 'lid',
            'contribution_category_alias' => 'lid',
            'activated' => true,
            'verified' => true,
            'address' => 'Voorbeeldstraat 123',
            'zip_code' => '1234 AB',
            'city' => 'Voorbeeldstad',
        ]);

        factory(App\User::class, 'member', 2)->create()->each(function ($u) {
            $u->subscriptions()->save(factory(App\Subscription::class)->make());
        });

        factory(App\User::class, 'member', 2)->create()->each(function ($u) {
            $u->subscriptions()->save(factory(App\Subscription::class, 'early_bird')->make());
        });
    }
}
