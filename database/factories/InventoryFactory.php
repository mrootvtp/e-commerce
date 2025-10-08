<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            'warehouse_id' => \App\Models\Warehouse::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
