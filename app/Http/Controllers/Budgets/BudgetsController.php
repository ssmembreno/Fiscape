<?php

namespace App\Http\Controllers\Budgets;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Budgets;
use App\Models\Categories;
use Inertia\Inertia;
use App\Http\Requests\Budgets\BudgetsRequest;

class BudgetsController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $budgets = Budgets::where('user_id', Auth::id())
            ->with('category')
            ->get();

        return Inertia::render('Budgets/Index', [
            'budgets' => $budgets
        ]);
    }


    public function create()
    {
        return Inertia::render('Budgets/Create', [
            'categories' => Categories::whereNull('user_id')
                ->orWhere('user_id', Auth::id())
                ->orderBy('name')
                ->get()
        ]);
    }


    public function store(BudgetsRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['amount_spent'] = 0;
        $data['status'] = $data['status'] ?? 1;

        // VALIDAR que NO exista un budget para esa categoría
        $exists = Budgets::where('user_id', Auth::id())
            ->where('category_id', $data['category_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'category_id' => 'Ya tienes un presupuesto para esta categoría.'
            ]);
        }

        Budgets::create($data);

        return redirect()->route('budgetsIndex')
            ->with('success', 'Presupuesto creado correctamente.');
    }


    public function edit(Budgets $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);

        return Inertia::render('Budgets/Edit', [
            'budget'     => $budget,
            'categories' => Categories::whereNull('user_id')
                ->orWhere('user_id', Auth::id())
                ->get()
        ]);
    }


    public function update(BudgetsRequest $request, Budgets $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = $data['status'] ?? 1;

        // Validar duplicado
        $exists = Budgets::where('user_id', Auth::id())
            ->where('category_id', $data['category_id'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'category_id' => 'Ya existe un presupuesto para esta categoría.'
            ]);
        }

        $budget->update($data);

        return redirect()->route('budgetsIndex')
            ->with('success', 'Presupuesto actualizado correctamente.');
    }


    public function destroy(Budgets $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);

        $budget->delete();

        return redirect()->route('budgetsIndex')
            ->with('success', 'Presupuesto eliminado correctamente.');
    }


    // REINICIAR 1 presupuesto
    public function reset(Budgets $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);

        $budget->update([
            'amount_spent' => 0
        ]);

        return back()->with('success', 'Presupuesto reiniciado.');
    }

    // Reiniciar todos los presupuestos del usuario
    public function resetAll()
    {
        Budgets::where('user_id', Auth::id())
            ->update(['amount_spent' => 0]);

        return back()->with('success', 'Todos los presupuestos han sido reiniciados.');
    }
}

