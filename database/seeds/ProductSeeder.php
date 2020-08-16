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
        factory(Product::class)->create([
            'category_id' => '1',
            'name' => 'game1',
            'slug' => 'game-1',
            'image' => 'public/game1.jpg']);

        factory(Product::class)->create([
            'category_id' => '1',
            'name' => 'game2',
            'slug' => 'game-2',
            'image' => 'public/game2.jpeg']);

        factory(Product::class)->create([
            'category_id' => '2',
            'name' => 'game3',
            'slug' => 'game-3',
            'image' => 'public/game3.jpg']);

        factory(Product::class)->create([
            'category_id' => '2',
            'name' => 'game4',
            'slug' => 'game-4',
            'image' => 'public/game4.png']);
    }
}
