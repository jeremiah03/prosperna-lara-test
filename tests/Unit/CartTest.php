<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_add_item_to_cart()
    {
        // Create user
        $user = User::factory()->create()->first();

        // Authenticate user
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->be($user, 'web');

        // Create category
        $category = Category::factory()->create();

        // Create product
        $products = Product::factory()->count(5)->create(['category_id' => $category->id]);

        // Add item to cart
        foreach ($products as $product) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $this->faker()->numberBetween(1, 10)
            ]);
        }

        // Get cart items
        $cart = Cart::where('user_id', $user->id)->get();

        $this->assertEquals($products->count(), $cart->count());
    }

    public function test_remove_item_from_cart()
    {
        // Create user
        $user = User::factory()->create()->first();

        // Authenticate user
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->be($user, 'web');

        // Create category
        $category = Category::factory()->create();

        // Create products
        $products = Product::factory()->count(5)->create(['category_id' => $category->id]);

        // Add items to cart
        foreach ($products as $product) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $this->faker()->numberBetween(1, 10)
            ]);
        }

        // Get cart items
        $carts = Cart::where('user_id', $user->id)->get();

        // Get first item
        $item = $carts->first();

        // Delete first item
        $item->delete();

        // Assert remove from database
        $this->assertDatabaseMissing('carts', ['id' => $item->id]);
    }
}
