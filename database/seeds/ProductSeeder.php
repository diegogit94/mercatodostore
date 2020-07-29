<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class)->create(['category_id' => '1', 'slug' => 'game-1']);
        factory(Product::class)->create(['category_id' => '2', 'slug' => 'game-2']);
        factory(Product::class)->create(['category_id' => '2', 'slug' => 'game-3']);
        factory(Product::class)->create(['category_id' => '2', 'slug' => 'game-4']);
    }
}
