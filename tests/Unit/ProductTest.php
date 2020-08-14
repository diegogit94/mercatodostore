<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use refreshDatabase;
    /** @test */
    public function aProductCanToggleVisibility()
    {
        $product = factory(Product::class)->create(['visible' => false]);

        $product->toggleVisibility();

        $this->assertTrue($product->visible);
    }
}
