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
            [
                'first_name' => 'Voorbeeld',
                'last_name' => 'Admin',
                'email' => 'admin@voorbeeld.hw',
                'email_hz' => 'admin@hz.hw',
                'password' => bcrypt('Admin123'),
                'account_type' => 'admin',
                'activated' => true,
                'verified' => true,
                'address' => 'Voorbeeldstraat 123',
                'zip_code' => '1234 AB',
                'city' => 'Voorbeeldstad',
            ],
            [
                'first_name' => 'Voorbeeld',
                'last_name' => 'Gebruiker',
                'email' => 'gebruiker@voorbeeld.hw',
                'email_hz' => 'gebruiker@hz.hw',
                'password' => bcrypt('Gebruiker123'),
                'account_type' => 'user',
                'activated' => true,
                'verified' => true,
                'address' => 'Voorbeeldstraat 123',
                'zip_code' => '1234 AB',
                'city' => 'Voorbeeldstad',
            ],
        ]);

        DB::table('users')->insert([
            [
                'first_name' => 'Voorbeeld',
                'last_name' => 'Lid',
                'email' => 'lid@voorbeeld.hw',
                'email_hz' => 'lid@hz.hw',
                'password' => bcrypt('Lid123'),
                'account_type' => 'user',
                'user_category' => 'lid',
                'activated' => true,
                'verified' => true,
                'address' => 'Voorbeeldstraat 123',
                'zip_code' => '1234 AB',
                'city' => 'Voorbeeldstad',
            ],
        ]);
    }
}
