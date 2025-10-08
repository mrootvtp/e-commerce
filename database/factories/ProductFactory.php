<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
       return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'description' => $this->faker->sentence(),
        ];
    }
}
