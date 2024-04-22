<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show register page
    public function create()
    {
        return view('users.register');
    }

    //Create a new user
    public function store(Request $request)
    {
        //vaidation
        $formFields = $request->validate([
            "name" => "required",
            "email" => ["required", "email", Rule::unique('users', 'email')],
            "password" => 'required|confirmed|min:6'
        ]);


        //Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create user
        $user = User::create($formFields);

        //Login 
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }


    //Logout user
    public function logout(Request $request)
    {

        auth()->logout();
        //invalidate user session and regenrate csrf tokens
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    //Show login page
    public function login()
    {
        return view('users.login');
    }

    //Login/Authenticate user
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            "email" => ["required", "email"],
            "password" => "required|min:6"
        ]);
        //The attempt method automatically takes care of hashing the provided plain-text password and comparing it with the hashed password stored in the database.
        //If the passwords match, attempt logs the user in and returns true, allowing the user to proceed to the authenticated area of the application.
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
