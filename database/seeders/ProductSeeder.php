<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Product::create([
                "name" => \Faker\Factory::create()->text(),
                "category" => ["Electronics", "Cleaning products", "Food", "Clothing"][rand(0, 3)],
                // "category" => ["fashion", "books", "electronics"][rand(0, 2)],
                "price" => rand(1000, 50000),
            ]);
        }
    }
}
