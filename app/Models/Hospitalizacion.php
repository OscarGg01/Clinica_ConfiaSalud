<?php 

// app/Models/Hospitalizacion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitalizacion extends Model
{
    protected $table = 'hospitalizaciones';

    protected $fillable = ['paciente_id','fecha','descripcion'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
