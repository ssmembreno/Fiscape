<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
    $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'description' => 'nullable|string|max:255',
        'transaction_date' => 'required|date',
        'category_id' => 'required|exists:categories,id',
    ]);

    $transaction = new Transaction();
    $transaction->user_id = auth()->id();
    $transaction->category_id = $request->category_id;
    $transaction->amount = $request->amount;
    $transaction->type = 'income'; 
    $transaction->description = $request->description;
    $transaction->transaction_date = $request->transaction_date;
    $transaction->save();

    return response()->json(['message' => 'Transacción añadida con éxito']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
