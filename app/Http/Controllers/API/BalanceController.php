<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $transactions = Transactions::where('user_id', $user->id)->get();
        $currentBalance = $transactions->sum('amount');

        $lastMonth = now()->subMonth();
        $twoMonthsAgo = now()->subMonths(2);

        $lastMonthTotal = $transactions->where('created_at', '>=', $lastMonth)->sum('amount');
        $previousMonthTotal = $transactions->whereBetween('created_at', [$twoMonthsAgo, $lastMonth])->sum('amount');

        $change = $previousMonthTotal == 0
            ? null
            : (($lastMonthTotal - $previousMonthTotal) / abs($previousMonthTotal)) * 100;

        return response()->json([
            'balance' => $currentBalance,
            'change' => $change,
        ]);
    } 
}
