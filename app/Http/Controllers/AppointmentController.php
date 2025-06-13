<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CitaAgendada;

class AppointmentController extends Controller
{
    /**
     * Busca paciente por DNI en tu BD local.
     */
    public function buscarPaciente(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8'
        ]);

        $pac = Paciente::where('dni', $request->dni)->first();

        return $pac
            ? response()->json($pac)
            : response()->json(null, 404);
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create()
    {
        $areas = Area::with('especialistas')->get();
        return view('citas.create', compact('areas'));
    }

    /**
     * Almacena una nueva cita y envía correo de confirmación.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dni'             => 'required|string|exists:pacientes,dni',
            'area_id'         => 'required|exists:areas,id',
            'especialista_id' => 'required|exists:especialistas,id',
            'fecha'           => 'required|date',
            'hora'            => 'required',
        ]);

        $cita = Cita::create($data);
        $paciente = Paciente::where('dni', $data['dni'])->first();

        Mail::to($paciente->email)
            ->send(new CitaAgendada($paciente, $cita));

        return redirect()
            ->route('citas.create')
            ->with('success', '¡La cita fue agendada correctamente! Te hemos enviado un correo de confirmación.');
    }

    /**
     * Muestra el formulario de acceso al historial (DNI + celular).
     */
    public function historialForm()
    {
        return view('citas.historial');
    }

    /**
     * Verifica DNI+celular y muestra las citas del paciente.
     */
    public function historialVerificar(Request $request)
    {
        $request->validate([
            'dni'     => 'required|digits:8',
            'celular' => 'required'
        ]);
    
        $dni     = $request->dni;
        $celular = $request->celular;
    
        $pac = Paciente::where('dni', $dni)
                       ->where('telefono', $celular)
                       ->first();
    
        if (! $pac) {
            return back()->with('error', 'DNI o celular incorrectos.');
        }
    
        session(['paciente_dni' => $dni]);
    
        // Próximas citas (hoy en adelante)
        $citasProx = Cita::where('dni', $dni)
                         ->whereDate('fecha', '>=', now())
                         ->with(['area','especialista'])
                         ->orderBy('fecha','asc')
                         ->get();
    
        // Citas pasadas (antes de hoy)
        $citasPas = Cita::where('dni', $dni)
                        ->whereDate('fecha', '<', now())
                        ->with(['area','especialista'])
                        ->orderBy('fecha','desc')
                        ->get();
    
        return view('citas.historial_list', compact('pac','citasProx','citasPas'));
    }
    

    /**
     * Muestra el formulario para reprogramar una cita.
     * Sólo si coincide el DNI en sesión.
     */
    public function edit(Cita $cita)
    {
        if (session('paciente_dni') !== $cita->dni) {
            abort(403, 'No autorizado.');
        }

        $areas = Area::with('especialistas')->get();
        return view('citas.edit', compact('cita','areas'));
    }

    /**
     * Actualiza la cita (reprogramación).
     */
    public function update(Request $request, Cita $cita)
    {
        // Verifica que el DNI en sesión coincida
        if (session('paciente_dni') !== $cita->dni) {
            abort(403, 'No autorizado.');
        }
    
        // Valida datos
        $data = $request->validate([
            'area_id'         => 'required|exists:areas,id',
            'especialista_id' => 'required|exists:especialistas,id',
            'fecha'           => 'required|date|after_or_equal:today',
            'hora'            => 'required',
        ]);
    
        // Actualiza la cita
        $cita->update($data);
    
        // Regresa al listado (historial_list.blade.php), con mensaje de éxito
        return back()->with('success', 'Cita reprogramada correctamente.');
    }
    

    /**
     * Almacena o actualiza solo los datos del paciente.
     */
    public function storePaciente(Request $request)
    {
        // Validación idéntica a la de store() para datos de paciente
        $data = $request->validate([
            'dni'              => 'required|digits:8',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'nombres'          => 'required|string',
            'fecha_nac'        => 'required|date',
            'sexo'             => 'required|in:Masculino,Femenino,Otro',
            'email'            => 'nullable|email',
            'telefono'         => 'nullable|string',
            'whatsapp'         => 'nullable|string',
            'ubicacion'        => 'nullable|string',
        ]);

        // Crear o actualizar paciente
        $paciente = Paciente::updateOrCreate(
            ['dni' => $data['dni']],
            $data
        );

        // Responder con JSON para confirmar al front
        return response()->json([
            'success'  => true,
            'message'  => 'Paciente registrado/actualizado correctamente.',
            'paciente' => $paciente,
        ]);
    }

    /**
     * Devuelve los horarios de un especialista según lo registrado en BD.
     */
    public function getHorarios(Request $request)
    {
        $request->validate([
            'especialista_id' => 'required|exists:especialistas,id',
        ]);

        $esp = \App\Models\Especialista::with('horarios')
                ->find($request->especialista_id);

        // Retornamos solo el array de horas en formato "HH:MM"
        $horas = $esp->horarios->pluck('hora');

        return response()->json($horas);
    }

    public function logout()
    {
        // Elimina la clave de sesión que identifica al paciente
        session()->forget('paciente_dni');

        // Redirige al formulario de ingreso de DNI+celular
        return redirect()->route('citas.historial.form');
    }

}
