<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CitaController;
use App\Models\Especialista;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('prueba');
});

Route::view('/prueba', 'prueba')
     ->name('prueba');

Route::view('/especialidades', 'especialidades')
     ->name('especialidades');

Route::view('/citas', 'citas')
     ->name('citas');

Route::get('/citas', [AppointmentController::class, 'create'])->name('citas.create');

Route::post('/citas', [AppointmentController::class, 'store'])->name('citas.store');

Route::get('/citas/historial', [AppointmentController::class, 'historialForm'])
     ->name('citas.historial.form');

// Verificar credenciales y mostrar citas
Route::post('/citas/historial', [AppointmentController::class, 'historialVerificar'])
     ->name('citas.historial.verificar');

// Editar cita (protegido)
Route::get('/citas/{cita}/edit', [AppointmentController::class, 'edit'])
     ->name('citas.edit');
     
Route::put('/citas/{cita}', [AppointmentController::class, 'update'])
     ->name('citas.update');

Route::post('/citas/especialistas', function (Request $request) {
     return Especialista::where('area_id', $request->area_id)->get();
 });

Route::post('/citas/horarios', [CitaController::class, 'getHorarios']);

Route::view('/nosotros', 'nosotros')->name('nosotros');

Route::view('/staff', 'staff')->name('staff');

Route::post('/citas/buscar-paciente', [AppointmentController::class, 'buscarPaciente'])->name('citas.buscarPaciente');

Route::post('/pacientes/store', [AppointmentController::class, 'storePaciente'])->name('pacientes.store');