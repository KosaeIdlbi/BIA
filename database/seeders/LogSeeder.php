<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 500; $i++) {
            ActivityLog::create([
                "user_id" => 2,
                "product_id" => $i,
                "viewed" => rand(0, 1),
                "incart" => rand(0, 1),
                "purchased" => rand(0, 1),
                "rating" => rand(0, 5),
            ]);
        }
    }
}
