<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test create category.
     *
     * @return void
     */
    public function test_create_category()
    {
        // Generate random category name
        $name = $this->faker()->word();

        // Create Category
        Category::create([
            'name' => $name,
        ]);

        // Assert database
        $this->assertDatabaseHas('categories', [
            'name' => $name
        ]);
    }

    public function test_edit_category()
    {
        // Generate random name
        $name = $this->faker()->word();

        // Create Category
        $category = Category::create([
            'name' => $name,
        ]);

        // Generate new random name
        $name2 = $this->faker()->word();

        // Update category with new name
        $category->name = $name2;
        $category->save();

        // Assert database
        $this->assertDatabaseHas('categories', [
            'name' => $name2
        ]);
    }
}
