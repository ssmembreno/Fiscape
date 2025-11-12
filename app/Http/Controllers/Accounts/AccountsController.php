<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\AccountsRequest;
use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AccountsController extends Controller
{
    public function index(){

        $accounts = Accounts::where('user_id', Auth::id())->get();

        return Inertia::render('Accounts/Index', [
            'accounts' => $accounts,
        ]);

    }

    public function create(){

        $accounts = Accounts::where('user_id' , Auth::id())->get();

        return Inertia::render('Accounts/Create', [
            'accounts' => $accounts,
        ]);
    }

    public function store(AccountsRequest $request){

        $validate = $request->validated();

        $validate['user_id'] = Auth::id();

        Accounts::create($validate);

        return redirect()->route('accountsIndex')->with('success', 'Cuenta creada correctamente');

    }

    public function edit(Accounts $accounts){

        return Inertia::render('Accounts/Edit' , [
            'accounts' => $accounts
        ]);
    }


    public function update(AccountsRequest $request, Accounts $accounts){

        $validate = $request->validated();

        $accounts->update([
            'name' => $validate['name'],
            'type' => $validate['type'],
            'currency' => $validate['currency'],
            'balance' => $validate['balance'],
            'description' => $validate['description']
        ]);

    }

    public function destroy(Accounts $accounts){
        $accounts->delete();
    }
}
