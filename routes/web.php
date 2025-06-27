<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\API\TransactionsController;
use App\Models\Transactions;
use App\Models\Categories;
use App\Http\Controllers\API\BalanceController;

Route::get('/', function () {
    return view('welcome');
});


// Login

    Route::post('/login', [AuthController::class, 'login']);
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


Route::middleware('auth')->group(function () {
    Route::post('/transactions', [TransactionsController::class, 'store']);

    Route::get('/balance', function () {
        $balance = Transactions::where('user_id', auth()->id())
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
            ->value('total');

        return response()->json([
            'balance' => $balance ?? 0,
            'change' => 3.67
        ]);
    });
});


Route::get('/categories', fn () => Categories::all());