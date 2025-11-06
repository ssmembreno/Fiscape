<?php

namespace App\Http\Controllers\Transacciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Categories;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Transactions\TransactionRequest;
use Psy\Readline\Transient;

class TransactionController extends Controller{
    
    public function index(){
        $transactions = Transactions::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();

        $categories = Categories::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'categories' => $categories
        ]);    
    }

    public function create(){
        $categories = Categories::get();

        return Inertia::render('Transactions/Create', [
            'categories' => $categories
        ]);
    }

    public function store(TransactionRequest $request){

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        Transactions::create($validated);

        return redirect()->route('transactionsIndex')->with('success', 'Transacción agregada correctamente.');
    }

    public function edit(Transactions $transaction){

        $categories = Categories::whereNull('user_id')
            -> orWhere('user_id', Auth::id())
            ->get();

        return Inertia::render('Transactions/Edit' , [
            'categories' => $categories,
            'transaction' => $transaction
        ]);
    }

    public function update(TransactionRequest $request, Transactions $transaction){

        $validated = $request->validated();

        $transaction->update([
            'category_id' => $validated['category_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('transactionsIndex')->with('success', 'Transacción actualizada correctamente.');
    }


    public function destroy(Transactions $transaction){
        $transaction->delete();
    }
}
