<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Programar envío de recordatorios de citas por email cada hora
// Envía recordatorios exactamente 24 horas antes de la cita (±15 minutos)
Schedule::command('citas:enviar-recordatorios')
    ->hourly()
    ->timezone('America/La_Paz')
    ->withoutOverlapping()
    ->onFailure(function () {
        \Log::error('Falló el envío de recordatorios de citas por email');
    })
    ->onSuccess(function () {
        \Log::info('Recordatorios de citas enviados exitosamente por email');
    });
