<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Procesa pagos futuros vencido y crea la transacción automaticamente
Artisan::command('process-upcoming-pays', function () {
    $this->call('app:process-upcoming-pays');
})->purpose('Procesa pagos futuros vencido y crea la transacción automaticamente');