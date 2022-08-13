<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'email' => 'jeremiahmanlapaz@gmail.com',
            'name' => 'jeremiah',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        \App\Models\Category::factory()
            ->count(5)
            ->has(\App\Models\Product::factory()->count(5), 'products')
            ->create();


        $user = \App\Models\User::first();

        $products = \App\Models\Product::take(5)->get();

        foreach ($products as $product) {
            \App\Models\Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => random_int(1, 10),
            ]);
        }

        // \App\Models\Cart::factory()
        //     ->count(10)
        //     ->for(\App\Models\User::factory())
        //     ->hasAttached(\App\Models\Product::factory(), ['product_id' => '', 'cart_id' => ''])
        //     ->create();
    }
}
