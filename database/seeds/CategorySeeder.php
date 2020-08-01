<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'id' => '1',
            'name' => 'Shooters',
            'slug' => 'shooters-games'
        ]);

        factory(Category::class)->create([
            'id' => '2',
            'name' => 'Horror',
            'slug' => 'horror-games'
        ]);
    }
}
