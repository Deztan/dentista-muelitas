<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cita;
use App\Mail\RecordatorioCitaMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarRecordatoriosCitas extends Command
{
    protected $signature = 'citas:enviar-recordatorios';
    protected $description = 'Envía recordatorios por correo a los pacientes con citas para mañana';

    public function handle()
    {
        $now = Carbon::now();

        $momentoObjetivo24h = $now->copy()->addHours(24);

        $rangoInicio = $momentoObjetivo24h->copy()->subMinutes(15);
        $rangoFin = $momentoObjetivo24h->copy()->addMinutes(15);

        $todasLasCitas = Cita::with(['paciente', 'odontologo', 'tratamiento'])
            ->where('recordatorio_enviado', false)
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->get();

        $citas = $todasLasCitas->filter(function ($cita) use ($rangoInicio, $rangoFin) {
            try {
                $fechaCita = Carbon::parse($cita->fecha);
                $horaCita = Carbon::parse($cita->hora);

                $fechaHoraCita = Carbon::create(
                    $fechaCita->year,
                    $fechaCita->month,
                    $fechaCita->day,
                    $horaCita->hour,
                    $horaCita->minute,
                    $horaCita->second
                );

                return $fechaHoraCita->between($rangoInicio, $rangoFin);
            } catch (\Exception $e) {
                return false;
            }
        });

        if ($citas->isEmpty()) {
            return 0;
        }

        $enviados = 0;
        $fallidos = 0;

        foreach ($citas as $cita) {
            try {
                if (!$cita->paciente->email) {
                    $fallidos++;
                    continue;
                }

                Mail::to($cita->paciente->email)->send(new RecordatorioCitaMail($cita));

                $cita->update([
                    'recordatorio_enviado' => true,
                    'recordatorio_fecha' => now()
                ]);

                $enviados++;
            } catch (\Exception $e) {
                $fallidos++;
            }
        }

        return 0;
    }
}
