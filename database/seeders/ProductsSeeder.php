<?php

namespace Database\Seeders;
use App\Models\Products;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create products using the factory
        Products::factory()->count(50)->create();
    }
}