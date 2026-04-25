<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view("user/auth/login");
    }
    public function store(Request $request)
    {
        if (Auth::guard("web")->attempt(["email" => $request->email, "password" => $request->password], (bool)$request->remember)) {
            $request->session()->regenerate(); // إعادة إنشاء الـ session ID للحماية
            return redirect()->route("home");
        } else {
            return redirect()->route("login.create")->with("fail", "email or password is not correct");
        }
    }
}
