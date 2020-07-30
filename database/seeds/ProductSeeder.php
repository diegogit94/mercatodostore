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
            'image' => 'https://pbs.twimg.com/media/ESlcJ_0XQAEWlAC.jpg']);

        factory(Product::class)->create([
            'category_id' => '1',
            'name' => 'game2',
            'slug' => 'game-2',
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2_5Sbp60ATQKKZThJV_bghG8AEnI6yaNZ5A5qGResIoNGG-oU&s']);

        factory(Product::class)->create([
            'category_id' => '2',
            'name' => 'game3',
            'slug' => 'game-3',
            'image' => 'https://marmotagamex.com/wp-contenido/uploads/2017/12/RE7-PS4.jpg']);

        factory(Product::class)->create([
            'category_id' => '2',
            'name' => 'game4',
            'slug' => 'game-4',
            'image' => 'https://d8mkdcmng3.imgix.net/61bd/643645.png?auto=format&bg=0FFF&fit=fill&h=600&q=100&w=600&s=6105fc9c4ae40cbe89491c75da9e0feb']);
    }
}
