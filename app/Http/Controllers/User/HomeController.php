<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $httpResponse = Http::get(route("hello", ["name" => "kosae"]));
        // return $httpResponse;
        $user = Auth::check() ? Auth::user() : null;
        return view("user.home", ["user" => $user]);
    }
}
