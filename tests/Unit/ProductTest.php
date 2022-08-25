<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test create product.
     *
     * @return void
     */
    public function test_create_product()
    {
        $category = Category::factory()->count(1)->create()->first();

        $product_name = $this->faker()->word();

        $product = Product::create([
            'category_id' => $category->id,
            'name' => $product_name,
            'description' => $product_name,
            'img_thumbnail' => '',
            'price' => 1
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

    /**
     * Test edit product.
     *
     * @return void
     */
    public function test_edit_product()
    {
        //Create category
        $category = Category::factory()->count(1)->create()->first();

        //Generate random product name
        $product_name = $this->faker()->word();

        //Create product
        $product = Product::create([
            'category_id' => $category->id,
            'name' => $product_name,
            'description' => 'product_test1',
            'img_thumbnail' => '',
            'price' => 1
        ]);

        // Update product
        $product->name = $product_name;
        $product->save();

        // Assert database
        $this->assertDatabaseHas('products', [
            'name' => $product_name
        ]);
    }
}
