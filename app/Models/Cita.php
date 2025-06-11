<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'dni', 'area_id', 'especialista_id', 'fecha', 'hora', 'notas', 'imagen'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // (Opcional) relaciones
    public function area() { return $this->belongsTo(Area::class); }
    public function especialista() { return $this->belongsTo(Especialista::class); }
    public function paciente() {return $this->belongsTo(Paciente::class, 'dni', 'dni'); }
    public function imagenes() {return $this->hasMany(CitaImagen::class);}

}
