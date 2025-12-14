<?php

namespace App\Http\Controllers\UpcomingPay;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpcomingPay\UpcomingPayRequest;
use App\Models\Accounts;
use Illuminate\Http\Request;
use App\Models\UpcomingPay;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;

class UpcomingPayController extends Controller
{
    public function index()
    {
        $upcomingPays = UpcomingPay::where('user_id', Auth::id())
        ->with('account', 'category')
        ->orderBy('created_at','desc')
        ->get();

        return Inertia::render('UpcomingPays/Index', [
            'upcomingPays' => $upcomingPays,
        ]);
    }

    public function create(){
        $accounts = Accounts::where('user_id', Auth::id())->get();
        $categories = Categories::all();

        return Inertia::render('UpcomingPays/Create', [
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function store(UpcomingPayRequest $request){
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        UpcomingPay::create($validated);

        // Verificar si el día actual coincide con el día de vencimiento
        $today = now();
        $dueDate = \Carbon\Carbon::parse($validated['due_date']);
        
        if ($today->day == $dueDate->day) {
            // Restar el monto del balance de la cuenta
            $account = Accounts::find($validated['account_id']);
            if ($account) {
                $account->balance -= $validated['amount'];
                $account->save();
            }
        }

        return redirect()->route('upcomingPaysIndex')->with('success', 'Pago futuro creado exitosamente');
    }
}
