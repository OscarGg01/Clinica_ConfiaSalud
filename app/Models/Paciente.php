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

    public function antecedentesFamiliares()
    {
        return $this->hasOne(AntecedenteFamiliar::class);
    }

    public function alergias()
    {
        return $this->hasOne(Alergia::class);
    }

    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }

    public function hospitalizaciones()
    {
        return $this->hasMany(Hospitalizacion::class);
    }

}
