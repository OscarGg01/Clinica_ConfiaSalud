<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use App\Models\Cita;
use App\Models\CitaImagen;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AntecedenteFamiliar;
use Carbon\Carbon;
use App\Models\Alergia;
use App\Models\Cirugia;
use App\Models\Hospitalizacion;

class DoctorController extends Controller
{
    /**
     * Muestra el formulario de login para doctores.
     */
    public function loginForm()
    {
        return view('doctores.login');
    }

    /**
     * Procesa el login de doctores usando email y teléfono como contraseña.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|digits:9',
        ]);

        $doc = Especialista::where('email', $data['email'])
                          ->where('telefono', $data['password'])
                          ->first();

        if (!$doc) {
            return back()->withErrors(['email' => 'Credenciales inválidas']);
        }

        session(['doctor_id' => $doc->id, 'doctor_nombre' => $doc->nombre]);

        return redirect()->route('doctor.dashboard');
    }

    /**
     * Muestra el dashboard con las próximas citas del especialista.
     */
    public function dashboard()
    {
        $doctorId = session('doctor_id');
        $nombre   = session('doctor_nombre');

        $citas = Cita::with(['paciente','area'])->where('especialista_id', session('doctor_id'))
        ->whereDate('fecha', '>=', Carbon::today())
        ->orderBy('fecha','asc')
        ->get();

        return view('doctores.dashboard', compact('nombre', 'citas'));
    }

    /**
     * Muestra los detalles de una cita (solo para el especialista propietario).
     */
    public function showCita(Cita $cita)
    {
        if (session('doctor_id') !== $cita->especialista_id) {
            abort(403, 'No autorizado.');
        }

        $cita->load(['paciente', 'imagenes']);

        return view('doctores.citas.show', compact('cita'));
    }

    /**
     * Actualiza notas, sube nuevas imágenes y elimina las marcadas.
     */
    public function updateDetalles(Request $request, Cita $cita)
    {
        // Autorización
        if (session('doctor_id') !== $cita->especialista_id) {
            abort(403, 'No autorizado.');
        }
    
        // Validación
        $data = $request->validate([
            'diagnostico'        => 'nullable|string|max:500',
            'notas'              => 'nullable|string|max:2000',
            'nuevasImagenes.*'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'eliminar'           => 'nullable|array',
            'eliminar.*'         => 'integer|exists:cita_imagenes,id',
        ]);
    
        // 1) Actualizar diagnóstico y notas
        $cita->diagnostico = $data['diagnostico'] ?? null;
        $cita->notas       = $data['notas']       ?? null;
        $cita->save();
    
        // 2) Eliminar imágenes marcadas
        if (!empty($data['eliminar'])) {
            $imgs = CitaImagen::whereIn('id', $data['eliminar'])->get();
            foreach ($imgs as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }
    
        // 3) Subir nuevas imágenes
        if ($request->hasFile('nuevasImagenes')) {
            foreach ($request->file('nuevasImagenes') as $file) {
                $path = $file->store('citas', 'public');
                CitaImagen::create([
                    'cita_id' => $cita->id,
                    'path'    => $path,
                ]);
            }
        }
    
        // 4) Retornar con éxito
        return back()->with('success', 'Detalles actualizados.');
    }
    

    public function historialPaciente(Request $request)
    {
        $request->validate(['dni' => 'required|digits:8']);
    
        $paciente = Paciente::where('dni', $request->dni)->firstOrFail();
    
        // Permitimos order_by: fecha, especialista, area
        $validSort = ['fecha','especialista','area'];
        $sort = in_array($request->order_by, $validSort)
              ? $request->order_by
              : 'fecha';
    
        $query = Cita::with(['area','especialista','imagenes'])
                     ->where('dni', $paciente->dni);
    
        // Aplicar orden
        if ($sort === 'especialista') {
            $query->join('especialistas','citas.especialista_id','=','especialistas.id')
                  ->orderBy('especialistas.nombre');
        } elseif ($sort === 'area') {
            $query->join('areas','citas.area_id','=','areas.id')
                  ->orderBy('areas.nombre');
        } else {
            $query->orderBy('fecha','desc');
        }
    
        // Al usar join, seleccionamos citas.*
        $citas = $query->select('citas.*')->get();
    
        return view('doctores.historial', compact('paciente','citas','sort'));
    }
    
    public function updateAntecedentes(Request $request, Paciente $paciente)
    {
        // Verificar doctor logueado sobre sus pacientes si aplica
        $request->validate([
            'texto' => 'nullable|string|max:5000',
        ]);

        // Crear o actualizar el registro
        AntecedenteFamiliar::updateOrCreate(
            ['paciente_id' => $paciente->id],
            ['texto'       => $request->input('texto')]
        );

        return back()->with('success', 'Antecedentes familiares guardados.');
    }

    public function logout()
    {
        // Eliminar datos de sesión
        session()->forget(['doctor_id','doctor_nombre']);

        // Redirigir al formulario de login
        return redirect()->route('doctor.login')->with('success', 'Has cerrado sesión correctamente.');
    }

    public function updateAlergias(Request $request, Paciente $paciente)
    {

        $data = $request->validate([
            'descripcion' => 'nullable|string|max:2000',
        ]);

        Alergia::updateOrCreate(
            ['paciente_id' => $paciente->id],
            ['descripcion' => $data['descripcion']]
        );

        return back()->with('success', 'Alergias actualizadas.');
    }

    public function storeCirugia(Request $request, Paciente $paciente)
    {
        $request->validate([
            'fecha'       => 'required|date',
            'descripcion' => 'required|string|max:2000',
        ]);

        Cirugia::create([
            'paciente_id' => $paciente->id,
            'fecha'       => $request->fecha,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success','Cirugía registrada.');
    }

    public function destroyCirugia(Cirugia $cirugia)
    {
        // opcional: verificar que sea del paciente correcto / doctor autorizado
        $cirugia->delete();
        return back()->with('success','Cirugía eliminada.');
    }

    public function storeHospitalizacion(Request $request, Paciente $paciente)
    {
        $request->validate([
            'fecha'       => 'required|date',
            'descripcion' => 'required|string|max:2000',
        ]);

        Hospitalizacion::create([
            'paciente_id' => $paciente->id,
            'fecha'       => $request->fecha,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success','Hospitalización registrada.');
    }

    public function destroyHospitalizacion(Hospitalizacion $hospitalizacion)
    {
        $hospitalizacion->delete();
        return back()->with('success','Hospitalización eliminada.');
    }

}
