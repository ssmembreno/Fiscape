<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        
        $userId = Auth::id();

        $balance = Accounts::where('user_id' , $userId)->sum('balance');
        $totalIngresos = Transactions::where('user_id', $userId)->where('type', 1)->sum('amount');
        $totalGastos = Transactions::where('user_id', $userId)->where('type', 2)->sum('amount');

        $ahorro = $totalIngresos - $totalGastos;

        $transaccionesRecientes = Transactions::where('user_id', $userId)
            ->with(['category', 'account'])
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return inertia('Dashboard/Index', [
            'balanceActual' => (float)$balance,
            'totalIngresos' => (float)$totalIngresos,
            'totalGastos' => (float)$totalGastos,
            'ahorro' => (float) $ahorro,
            'transaccionesRecientes' => $transaccionesRecientes,
        ]);
    }
}
