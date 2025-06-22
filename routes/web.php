<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});


// Login
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::get('/register' , [RegisterController::class , 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'UserRegister']);


Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth');