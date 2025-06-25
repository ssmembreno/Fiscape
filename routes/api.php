<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;
use \App\Models\Transactions;
use \App\Models\Categories;


Route::middleware('auth')->post('/transactions', [TransactionsController::class, 'store']);

Route::get('/categories', function () {
    return \App\Models\Categories::all();
});

Route::middleware('auth')->get('/balance', function () {
    $balance = Transactions::where('user_id', auth()->id())
        ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
        ->value('total');

    $change = 3.67;

    return response()->json([
        'balance' => $balance,
        'change' => $change
    ]);
});
