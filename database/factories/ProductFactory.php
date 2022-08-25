<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => function ($category_id) {
                if($category_id) {
                    return $category_id;
                }
                return Category::class;
            },
            'name' => fake()->word(),
            'img_thumbnail' => fake()->imageUrl(450, 300),
            'description' => fake()->text(),
            'price' => fake()->randomDigitNotNull(),
        ];
    }
}
