<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        // Check if email exists in the database
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Email doesn't exist, clear everything
            return back()->withInput([])->with('error', 'User not found. Please try again');
        }

        // Email exists, now check credentials (This code contains remember me functionality)
        $remember = $request->filled('remember');

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            session(['email' => Auth::user()->email]);
            return redirect()->intended('dashboard');
        }


         // Password incorrect: keep email only
            return back()->withInput(['email' => $email]) ->with('error', 'Incorrect password. Please try again');
    }

    public function dashboard() {
             return view('dashboard');
    }
}
