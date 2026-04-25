<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $user = Auth::check() ? Auth::user() : null;
        return view("user.product-details", ["user" => $user, "product" => Product::with("ActivityLog")->findOrFail($id)]);
    }
}
