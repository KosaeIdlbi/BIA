<?php

namespace App\Http\Controllers\User\Auth;

use App\Events\VerificationRequire;
use App\Http\Controllers\Controller;
use App\Mail\Verification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view("user/auth/register");
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            "name" => trim($request->name),
            "email" => trim($request->email),
            "password" => Hash::make(trim($request->password)),
            "country" => $request->country,
            "age" => $request->age
        ]);
        Auth::guard("web")->login($user);
        return redirect()->route("home");
    }
}
