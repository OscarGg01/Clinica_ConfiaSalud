<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CitaController;
use App\Models\Especialista;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\BasicAdmin;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DoctorController;
use App\Http\Middleware\DoctorAuth;


Route::get('/', function () {return view('prueba');});

Route::view('/prueba', 'prueba')->name('prueba');
Route::view('/especialidades', 'especialidades')->name('especialidades');

Route::view('/citas', 'citas')->name('citas');

Route::get('/citas', [AppointmentController::class, 'create'])->name('citas.create');

Route::post('/citas', [AppointmentController::class, 'store'])->name('citas.store');

Route::get('/citas/historial', [AppointmentController::class, 'historialForm'])->name('citas.historial.form');

// Verificar credenciales y mostrar citas
Route::post('/citas/historial', [AppointmentController::class, 'historialVerificar'])->name('citas.historial.verificar');

Route::get('/citas/logout', [AppointmentController::class, 'logout'])->name('citas.logout');

// Editar cita (protegido)
Route::get('/citas/{cita}/edit', [AppointmentController::class, 'edit'])->name('citas.edit');
     
Route::put('/citas/{cita}', [AppointmentController::class, 'update'])->name('citas.update');

Route::post('/citas/especialistas', function (Request $request) {return Especialista::where('area_id', $request->area_id)->get();});

Route::post('/citas/horarios', [CitaController::class, 'getHorarios']);

Route::view('/nosotros', 'nosotros')->name('nosotros');

Route::view('/staff', 'staff')->name('staff');

Route::post('/citas/buscar-paciente', [AppointmentController::class, 'buscarPaciente'])->name('citas.buscarPaciente');

Route::post('/pacientes/store', [AppointmentController::class, 'storePaciente'])->name('pacientes.store');

Route::post('/citas/horarios', [AppointmentController::class, 'getHorarios'])->name('citas.horarios');

Route::prefix('admin')->middleware(BasicAdmin::class)->group(function() {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD de Especialistas
    Route::resource('especialistas', EspecialistaController::class)->except('show');

    // CRUD de Áreas
    Route::resource('areas', AreaController::class)->except('show');

    // CRUD de Horarios
    Route::resource('horarios', HorarioController::class)->except('show');

     Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');
     
     // Ruta para la política de privacidad
     Route::view('/politica-privacidad', 'politica_privacidad')->name('politica.privacidad');
});

Route::get  ('/doctoresAdmin',      [DoctorController::class, 'loginForm'])->name('doctor.login');
Route::post ('/doctoresAdmin/login',[DoctorController::class, 'login'])->name('doctor.login.submit');

Route::middleware(DoctorAuth::class)->group(function(){
     // Dashboard bienvenido
     Route::get('/doctoresAdmin/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
     Route::get('/doctoresAdmin/citas/{cita}', [DoctorController::class,'showCita'])->name('doctor.citas.show');
     Route::get('/doctoresAdmin/citas/{cita}', [DoctorController::class,'showCita'])->name('doctor.citas.show');
     Route::put('/doctoresAdmin/citas/{cita}/notas', [DoctorController::class,'updateNotas'])->name('doctor.citas.notas.update');
     Route::put('/doctoresAdmin/citas/{cita}/detalles', [DoctorController::class,'updateDetalles'])->name('doctor.citas.detalles.update');
     Route::get('/doctoresAdmin/historial', [DoctorController::class,'historialPaciente'])->name('doctor.historial');
     Route::put('/doctoresAdmin/citas/{cita}/detalles', [DoctorController::class,'updateDetalles'])->name('doctor.citas.detalles.update');
     Route::put('/doctoresAdmin/paciente/{paciente}/antecedentes', [DoctorController::class, 'updateAntecedentes'])->name('doctor.paciente.antecedentes.update');
     Route::get('/doctoresAdmin/logout', [DoctorController::class, 'logout'])->name('doctor.logout');
     Route::put('/doctoresAdmin/paciente/{paciente}/alergias', [DoctorController::class,'updateAlergias'])->name('doctor.paciente.alergias.update');

     Route::post('/doctoresAdmin/paciente/{paciente}/cirugias', [DoctorController::class,'storeCirugia'])->name('doctor.paciente.cirugias.store');
     Route::delete('/doctoresAdmin/cirugias/{cirugia}', [DoctorController::class,'destroyCirugia'])->name('doctor.paciente.cirugias.destroy');

     Route::post('/doctoresAdmin/paciente/{paciente}/hospitalizaciones', [DoctorController::class,'storeHospitalizacion'])->name('doctor.paciente.hospitalizaciones.store');
     Route::delete('/doctoresAdmin/hospitalizaciones/{hospitalizacion}', [DoctorController::class,'destroyHospitalizacion'])->name('doctor.paciente.hospitalizaciones.destroy');
 });