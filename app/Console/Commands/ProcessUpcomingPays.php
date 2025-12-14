<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UpcomingPay;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessUpcomingPays extends Command
{

    protected $signature = 'app:process-upcoming-pays';

    protected $description = 'Procesa pagos futuros vencido y crea la transacción automaticamente';

    public function handle()
    {
        // Usar la fecha actual
        $today = Carbon::now();
        $this->info("Fecha usada para procesar: " . $today->toDateString());
        
        $pays = UpcomingPay::where('status', UpcomingPay::PENDIENTE)
            ->whereDate('due_date', '<=', $today)
            ->whereNull('transaction_id')
            ->get();

        $this->info("Pagos encontrados para procesar: " . $pays->count());

        foreach ($pays as $pay) {
            try {
                DB::transaction(function () use ($pay) {

                    //Crear transacción
                    $transaction = Transactions::create([
                        'user_id'    => $pay->user_id,
                        'account_id' => $pay->account_id,
                        'category_id'=> $pay->category_id,
                        'amount'     => $pay->amount,
                        'type'       => Transactions::TYPE_GASTO,
                        'date'       => $pay->due_date,
                        'description'=> 'Pago automático: ' . ($pay->name ?? 'Pago programado'),
                    ]);

                    // 1. ACTUALIZAR CUENTA (Restar saldo)
                    $account = \App\Models\Accounts::find($pay->account_id);
                    if ($account) {
                        $account->balance -= $pay->amount;
                        $account->save();
                    }

                    // 2. ACTUALIZAR PRESUPUESTO (Sumar gasto)
                    $budget = \App\Models\Budgets::where('user_id', $pay->user_id)
                        ->where('category_id', $pay->category_id)
                        ->first();
                    
                    if ($budget) {
                        $budget->amount_spent += $pay->amount;
                        $budget->save();
                    }

                    // Marcar UpcomingPay como pagado
                    $pay->status = UpcomingPay::PAGADO;
                    $pay->transaction_id = $transaction->id;
                    $pay->save();
                    
                    $this->info("Pago procesado: " . $pay->name);
                });
            } catch (\Exception $e) {
                $this->error("Error procesando pago {$pay->id}: " . $e->getMessage());
            }
        }
    }
}
