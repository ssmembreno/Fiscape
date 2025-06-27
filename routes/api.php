<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Models\Transactions;
use \App\Models\Categories;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\API\BalanceController;


Route::middleware('auth')->get('/balance', [BalanceController::class, 'index']);

Route::get('/categories', fn () => Categories::all());
