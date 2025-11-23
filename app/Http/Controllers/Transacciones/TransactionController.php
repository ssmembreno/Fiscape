<?php

namespace App\Http\Controllers\Transacciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Categories;
use App\Models\Budgets;
use App\Models\Accounts;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Transactions\TransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
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
            'categories'   => $categories
        ]);
    }

    public function create()
    {
        return Inertia::render('Transactions/Create', [
            'categories' => Categories::whereNull('user_id')
                ->orWhere('user_id', Auth::id())
                ->get(),
            'accountsUserCreate' => Accounts::where('user_id', Auth::id())->get()
        ]);
    }


    public function store(TransactionRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $transaction = Transactions::create($validated);

        $this->updateAccountBalanceOnCreate($transaction);
        $this->updateBudgetOnCreate($transaction);

        return redirect()->route('transactionsIndex')
            ->with('success', 'Transacción agregada correctamente.');
    }


    public function edit(Transactions $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
            'categories'  => Categories::whereNull('user_id')
                ->orWhere('user_id', Auth::id())
                ->get()
        ]);
    }


    public function update(TransactionRequest $request, Transactions $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $old = $transaction->replicate();
        $validated = $request->validated();

        $transaction->update($validated);

        $this->updateAccountBalanceOnUpdate($old, $transaction);
        $this->updateBudgetOnUpdate($old, $transaction);

        return redirect()->route('transactionsIndex')
            ->with('success', 'Transacción actualizada correctamente.');
    }


    /**
     * DELETE
     */
    public function destroy(Transactions $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $this->updateAccountBalanceOnDelete($transaction);
        $this->updateBudgetOnDelete($transaction);

        $transaction->delete();

        return redirect()->route('transactionsIndex')
            ->with('success', 'Transacción eliminada correctamente.');
    }


    /**********************************************
     *  MÉTODOS PRIVADOS PARA BUDGET Y ACCOUNT
     **********************************************/


    /**
     * 1. ACTUALIZAR CUENTA (CREATE)
     */
    private function updateAccountBalanceOnCreate($t)
    {
        $account = Accounts::find($t->account_id);
        if (!$account) return;

        if ($t->type == Transactions::TYPE_INGRESO) {
            $account->balance += $t->amount;
        } else {
            $account->balance -= $t->amount;
        }
        $account->save();
    }


    /**
     * 2. ACTUALIZAR CUENTA (UPDATE)
     */
    private function updateAccountBalanceOnUpdate($old, $new)
    {
        $account = Accounts::find($new->account_id);
        if (!$account) return;

        // Revertir el viejo
        if ($old->type == Transactions::TYPE_INGRESO) {
            $account->balance -= $old->amount;
        } else {
            $account->balance += $old->amount;
        }

        // Aplicar el nuevo
        if ($new->type == Transactions::TYPE_INGRESO) {
            $account->balance += $new->amount;
        } else {
            $account->balance -= $new->amount;
        }

        $account->save();
    }


    /**
     * 3. ACTUALIZAR CUENTA (DELETE)
     */
    private function updateAccountBalanceOnDelete($t)
    {
        $account = Accounts::find($t->account_id);
        if (!$account) return;

        if ($t->type == Transactions::TYPE_INGRESO) {
            $account->balance -= $t->amount;
        } else {
            $account->balance += $t->amount;
        }

        $account->save();
    }


    /**
     * 4. SUMAR A BUDGET (CREATE)
     */
    private function updateBudgetOnCreate($t)
    {
        if ($t->type != Transactions::TYPE_GASTO) return;

        $budget = Budgets::where('user_id', Auth::id())
            ->where('category_id', $t->category_id)
            ->first();

        if (!$budget) return;

        $budget->amount_spent += $t->amount;
        $budget->save();
    }


    /**
     * 5. UPDATE (RESTA VIEJO + SUMA NUEVO)
     */
    private function updateBudgetOnUpdate($old, $new)
    {
        // Si el viejo era gasto → restar
        if ($old->type == Transactions::TYPE_GASTO) {
            $budgetOld = Budgets::where('user_id', Auth::id())
                ->where('category_id', $old->category_id)
                ->first();

            if ($budgetOld) {
                $budgetOld->amount_spent -= $old->amount;
                if ($budgetOld->amount_spent < 0) $budgetOld->amount_spent = 0;
                $budgetOld->save();
            }
        }

        // Si el nuevo es gasto → sumar
        if ($new->type == Transactions::TYPE_GASTO) {
            $budgetNew = Budgets::where('user_id', Auth::id())
                ->where('category_id', $new->category_id)
                ->first();

            if ($budgetNew) {
                $budgetNew->amount_spent += $new->amount;
                $budgetNew->save();
            }
        }
    }


    /**
     * 6. ELIMINAR → RESTAR BUDGET
     */
    private function updateBudgetOnDelete($t)
    {
        if ($t->type != Transactions::TYPE_GASTO) return;

        $budget = Budgets::where('user_id', Auth::id())
            ->where('category_id', $t->category_id)
            ->first();

        if (!$budget) return;

        $budget->amount_spent -= $t->amount;
        if ($budget->amount_spent < 0) $budget->amount_spent = 0;

        $budget->save();
    }
}

