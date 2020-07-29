<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->truncateTables([
//           'categories',
//           'products',
//            'users'
//        ]);

        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }

    /**
     *This method desactivates the foreign keys and then activates them again
     * once the seeders have been generated again, as a parameter it recieves
     * the name of the tables that you want to delete
     * @param $tables
     */

//    protected function truncateTables(array $tables): void
//    {
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
//
//        foreach ($tables as $table) {
//            DB::table($table)->truncate();
//            }
//
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
//    }
}
