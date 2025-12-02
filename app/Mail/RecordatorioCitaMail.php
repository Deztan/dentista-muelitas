<?php

namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class RecordatorioCitaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;
    public $paciente;
    public $odontologo;
    public $tratamiento;
    public $fechaFormateada;
    public $horaFormateada;

    /**
     * Create a new message instance.
     */
    public function __construct(Cita $cita)
    {
        $this->cita = $cita;
        $this->paciente = $cita->paciente;
        $this->odontologo = $cita->odontologo;
        $this->tratamiento = $cita->tratamiento;

        // Formatear fecha y hora en español
        Carbon::setLocale('es');
        $this->fechaFormateada = Carbon::parse($cita->fecha)->isoFormat('dddd D [de] MMMM [de] YYYY');
        $this->horaFormateada = Carbon::parse($cita->hora)->format('H:i');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🦷 Recordatorio de Cita - Clínica Dental Muelitas',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recordatorio-cita',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
