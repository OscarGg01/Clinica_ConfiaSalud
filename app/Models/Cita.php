<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'dni', 'area_id', 'especialista_id', 'fecha', 'hora'
    ];

    protected $casts = [
        'fecha' => 'date',   // o 'datetime' si incluyes hora en la misma columna
    ];

    // (Opcional) relaciones
    public function area() { return $this->belongsTo(Area::class); }
    public function especialista() { return $this->belongsTo(Especialista::class); }
    public function paciente() {return $this->belongsTo(Paciente::class); }
}
