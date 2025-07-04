<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create([
            'title' => 'Sample Product',
            'description' => 'This is a sample product description.',
            'image' => 'https://via.placeholder.com/150',
        ]);
    }
}
