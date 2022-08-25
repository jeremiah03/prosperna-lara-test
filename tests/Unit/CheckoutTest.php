<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Category;
use App\Models\CheckOut;
use App\Models\CheckOutProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test checkout items from cart.
     *
     * @return void
     */
    public function test_checkout_cart()
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

        $total_amount = 0;

        // Create checkout
        $checkout = CheckOut::create([
            'user_id' => auth()->user()->id,
            'address' => $this->faker()->address(),
            'address2' => $this->faker()->address(),
            'country' => $this->faker()->country(),
            'zip' => $this->faker()->numberBetween(1000, 9999),
            'payment_method' => Arr::random(['Credit card', 'Cash on delivery']),
            'total_amount' => $total_amount,
        ]);

        $user_cart = $user->cart;

        // Compute total amount and create checkout product
        foreach ($user_cart as $item) {
            $total_amount += $item->price * $item->quantity;

            CheckOutProduct::create([
                'check_out_id' => $checkout->id,
                'product_id' => $item->cart->product_id,
                'quantity' => $item->cart->quantity,
                'amount' => $item->price
            ]);
        }

        // Set total amount
        $checkout->total_amount = $total_amount;
        $checkout->save();

        // Assert equals computated total amount and updated total_amount
        $this->assertEquals($total_amount, $checkout->total_amount);

        // Assert checkout exists in database
        $this->assertDatabaseHas('checkout', [
            'id' => $checkout->id
        ]);
    }
}
