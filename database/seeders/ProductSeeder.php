<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Product::create([
            'name' => 'Sample Product 1',
            'description' => 'This is a description for Sample Product 1.',
            'price' => 19.99,
            'image' => 'product1.jpg',
        ]);

        Product::factory()->count(50)->create();

    }
}
