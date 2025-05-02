<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Especialista;
use App\Mail\CitaAgendada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitaController extends Controller
{
    public function store(Request $request)
    {
        // Validación
        $data = $request->validate([
            'dni'             => 'required|string',
            'area_id'         => 'required|exists:areas,id',
            'especialista_id' => 'required|exists:especialistas,id',
            'fecha'           => 'required|date',
            'hora'            => 'required',
        ]);

        // Obtener paciente por DNI
        $paciente = Paciente::where('dni', $data['dni'])->firstOrFail();
        
        // Obtener datos del especialista
        $especialista = Especialista::with('area')->findOrFail($data['especialista_id']);

        // Crear cita
        $cita = Cita::create([
            'paciente_id'     => $paciente->id,
            'especialista_id' => $data['especialista_id'],
            'fecha'           => $data['fecha'],
            'hora'            => $data['hora'],
            'area_id'         => $data['area_id']
        ]);

        // Enviar correo de confirmación
        Mail::to($paciente->email)
            ->send(new CitaAgendada(
                $cita,
                $paciente,
                $especialista
            ));

        return back()->with('success', 'Cita registrada y correo de confirmación enviado.');
    }
}