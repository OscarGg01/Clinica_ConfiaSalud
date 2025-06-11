<?php
namespace App\Http\Controllers;

use App\Models\Especialista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cita;

class DoctorController extends Controller
{
    // 1) Muestra el formulario de login
    public function loginForm()
    {
        return view('doctores.login');
    }

    // 2) Procesa el login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|digits:9', // teléfono de 9 dígitos
        ]);

        $doc = Especialista::where('email', $data['email'])
                          ->where('telefono', $data['password'])
                          ->first();

        if (!$doc) {
            return back()->withErrors(['email' => 'Credenciales inválidas']);
        }

        // Guardar en sesión
        session(['doctor_id' => $doc->id, 'doctor_nombre' => $doc->nombre]);

        return redirect()->route('doctor.dashboard');
    }

    // 3) Muestra el dashboard con bienvenida
    public function dashboard()
    {
        // Recuperar datos de sesión
        $doctorId = session('doctor_id');
        $nombre   = session('doctor_nombre');
    
        // Obtener las citas para ese especialista, con datos de paciente y área
        $citas = \App\Models\Cita::with(['paciente','area'])
                   ->where('especialista_id', $doctorId)
                   ->whereDate('fecha', '>=', now())
                   ->orderBy('fecha','asc')
                   ->get();
    
        return view('doctores.dashboard', compact('nombre','citas'));
    }

    public function showCita(\App\Models\Cita $cita)
    {
        // Asegurar que el doctor vea solo sus propias citas
        if (session('doctor_id') !== $cita->especialista_id) {
            abort(403, 'No autorizado.');
        }
        // Carga también el paciente
        $cita->load('paciente');
        return view('doctores.citas.show', compact('cita'));
    }

    public function updateNotas(Request $request, Cita $cita)
    {
        // Verificación de propietario
        if (session('doctor_id') !== $cita->especialista_id) {
            abort(403, 'No autorizado.');
        }
    
        // Validar notas y archivo
        $data = $request->validate([
            'notas'  => 'nullable|string|max:2000',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Guardar notas
        $cita->notas = $data['notas'] ?? null;
    
        // Si hay imagen, procesarla
        if ($request->hasFile('imagen')) {
            // Elimina la anterior si existe
            if ($cita->imagen && Storage::disk('public')->exists($cita->imagen)) {
                Storage::disk('public')->delete($cita->imagen);
            }
            // Guarda la nueva y almacena la ruta
            $path = $request->file('imagen')->store('citas', 'public');
            $cita->imagen = $path;
        }
    
        // Persistir en BD
        $cita->save();
    
        return back()->with('success', 'Notas e imagen actualizadas.');
    }
    
    
}
