<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});


// Login

    Route::post('/login', [AuthController::class, 'Login']);
    Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
    
    Route::post('/register', [RegisterController::class, 'UserRegister']);
    Route::get('/register' , [RegisterController::class , 'showRegistrationForm'])->name('register');

Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth');


Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});