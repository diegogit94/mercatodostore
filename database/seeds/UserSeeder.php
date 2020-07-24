<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'id' => 1,
           'name' => 'Diego',
           'email' => 'diego@mercatodo.com',
           'password' => '123456789',
            'user_type' => 'admin',
            'active' => true,
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Cliente',
            'email' => 'cliente@mercatodo.com',
            'password' => '123456789',
            'user_type' => 'client',
            'active' => true,
        ]);
    }
}
