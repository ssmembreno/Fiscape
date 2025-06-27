<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    
    public function store(Request $request){
        $request->validate([
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Transactions::create([
            'user_id' => Auth::id(),
            'amount' => (float) $request->amount,
            'transaction_date' => $request->transaction_date,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Transacción guardada correctamente.']);
    }
}
