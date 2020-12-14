<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
           'password' => bcrypt('123456789'),
            'user_type' => 'admin',
            'active' => true,
            'created_at' => '2020-07-24 20:34:47',
            'updated_at' => '2020-07-24 20:34:47'
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Cliente',
            'email' => 'cliente@mercatodo.com',
            'password' => bcrypt('123456789'),
            'user_type' => 'client',
            'active' => true,
            'created_at' => '2020-07-24 21:34:47',
            'updated_at' => '2020-07-24 21:34:47'
        ]);

        factory(User::class)->times(38)->create();
    }
}
