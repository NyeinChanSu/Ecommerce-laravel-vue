<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => $name,
            // Use faker to generate a unique slug to avoid unique index collisions
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 500),
            'stock' => $this->faker->numberBetween(0, 200),
            'images' => [
                $this->faker->imageUrl(640, 480, 'technics', true),
                $this->faker->imageUrl(640, 480, 'technics', true),
            ],
        ];
    }
}
