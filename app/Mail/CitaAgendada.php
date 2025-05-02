<?php

namespace App\Mail;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CitaAgendada extends Mailable
{
    use Queueable, SerializesModels;

    public Paciente $paciente;
    public Cita     $cita;

    public function __construct(Paciente $paciente, Cita $cita)
    {
        $this->paciente = $paciente;
        $this->cita     = $cita;
    }

    public function build()
    {
        return $this
            ->subject('Confirmación de tu cita en Clínica ConfíaSalud')
            ->view('emails.cita_agendada')   // tu plantilla: resources/views/emails/cita_agendada.blade.php
            ->with([
                'paciente' => $this->paciente,
                'cita'     => $this->cita,
            ]);
    }
}
