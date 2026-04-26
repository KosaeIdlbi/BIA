<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
Route::fallback(function () {
    return response("page not found");
});
require __DIR__ . "/UserRoutes.php";
