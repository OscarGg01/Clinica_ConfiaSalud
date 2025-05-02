<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'dni','apellido_paterno','apellido_materno',
        'nombres','fecha_nac','sexo','email',
        'telefono','whatsapp','ubicacion'
    ];
}
