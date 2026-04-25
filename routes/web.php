<?php

use Illuminate\Support\Facades\Route;



Route::fallback(function () {
    return response("page not found");
});
require __DIR__ . "/UserRoutes.php";
