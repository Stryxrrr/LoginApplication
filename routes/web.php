<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [AuthController::class, 'showLogin'])->name('login.page');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [AuthController::class, 'dashboard'])
     ->middleware('auth')
     ->name('dashboard');

Route::get('/logout', function () {
    Auth::logout(); // Log out the user
    session()->invalidate(); // Clear session
    session()->regenerateToken(); // Prevent session fixation
    return redirect('/')->with('message', 'You have been logged out.');
})->name('logout');
