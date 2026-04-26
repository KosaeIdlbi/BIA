<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
Route::get('/seed', function () {
    for ($i = 1; $i <= 100; $i++) {
        Product::create([
            "name" => "product_" . rand(1, 10000),
            "category" => ["Electronics", "Cleaning products", "Food", "Clothing"][rand(0, 3)],
            // "category" => ["fashion", "books", "electronics"][rand(0, 2)],
            "price" => rand(100, 5000),
        ]);
    }
    return redirect()->back();
});
Route::fallback(function () {
    return response("page not found");
});
require __DIR__ . "/UserRoutes.php";
