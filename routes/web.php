<?php

use App\Http\Controllers\Accounts\AccountsController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Transacciones\TransactionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Transacciones
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactionsIndex');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactionsCreate');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactionsEdit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactionsUpdate');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');


    // Categories
    Route::get('/categories', [CategoriesController::class , 'index'])->name('categoriesIndex');
    Route::get('/categories/create', [CategoriesController::class , 'create'])->name('categoriesCreate');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categoriesStore');
    Route::get('/categories/{categories}/edit' , [CategoriesController::class , 'edit'])->name('categoriesEdit');
    Route::put('/categories/{categories}' , [CategoriesController::class , 'update'])->name('categoriesUpdate');
    Route::delete('/categories/{categories}' , [CategoriesController::class , 'destroy'])->name('categoriesDestroy');

    // Accounts
    Route::get('/accounts', [AccountsController::class, 'index'])->name('accountsIndex');
    Route::get('/accounts/create', [AccountsController::class, 'create'])->name('accountsCreate');
    Route::post('/accounts' , [AccountsController::class, 'store'])->name('accountsStore');
    Route::get('/accounts/{accounts}/edit', [AccountsController::class, 'edit'])->name('accountsEdit');
    Route::put('/accounts/{accounts}', [AccountsController::class, 'update'])->name('accountsUpdate');
    Route::delete('Accounts/{accounts}', [AccountsController::class, 'destroy'])->name('accountsDestroy');

});

require __DIR__.'/auth.php';
