<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(){
        return view("users.register");
    }

    public function store(Request $request){
        $formFields=$request->validate([
            "name"=>["required", "min:3"],
            "email"=>["required", "email", Rule::unique("users", "email")],
            "password"=>["required", "confirmed", "min:6"],
        ]);

        // Hash The PassWord
        $formFields["password"]=bcrypt($formFields["password"]);

        // Create The User
        $user=User::create($formFields);

        // Login
        auth()->login($user);

        return redirect("/")->with("message", "Thanks For Being Here !");
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect("/")->with("message", "You Have Been Logged Out");
    }

    public function login()
    {
        return view("users.login");
    }

    public function authenticate(Request $request){
        $formFields=$request->validate([
            "email"=>["required", "email"],
            "password"=>["required"]
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect("/")->with("message", "You're Now Logged In");
        }
        return back()->withErrors(["email"=>"Invalide Credentials !"])->onlyInput("email");
    }
}
