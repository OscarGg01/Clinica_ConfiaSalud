<?php
// app/Models/CitaImagen.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitaImagen extends Model
{
    protected $table = 'cita_imagenes';
    protected $fillable = ['cita_id','path'];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
