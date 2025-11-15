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
use App\Models\Accounts;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller{
    
    public function index(){
        $transactions = Transactions::where('user_id', Auth::id())
            ->with(['category', 'account'])
            ->orderBy('date', 'asc')
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

        $accountsUserCreate = Accounts::get();

        return Inertia::render('Transactions/Create', [
            'categories' => $categories,
            'accountsUserCreate' => $accountsUserCreate
        ]);
    }

    public function store(TransactionRequest $request){

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        $transaction = Transactions::create($validated);

        $account = Accounts::find($validated['account_id']);

        //Actulizamos el balance segun si es ingreso o gasto
        if($account){
            if($transaction->type == Transactions::TYPE_INGRESO){
                $account->balance += $transaction->amount;
            }elseif($transaction->type == Transactions::TYPE_GASTO){
                $account->balance -= $transaction->amount;
            }
        $account->save();    
        }

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


    public function destroy(Transactions $transaction)
    {
        $account = Accounts::find($transaction->account_id);

        if ($account) {
            // Revertir el efecto de la transacción
            if ($transaction->type == Transactions::TYPE_INGRESO) {
                $account->balance -= $transaction->amount;
            } elseif ($transaction->type == Transactions::TYPE_GASTO) {
                $account->balance += $transaction->amount;
            }

            $account->save();
        }

        $transaction->delete();

        return redirect()->route('transactionsIndex')->with('success', 'Transacción eliminada y balance revertido.');
    }

}
