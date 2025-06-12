<?php

// app/Models/Cirugia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cirugia extends Model
{
    protected $fillable = ['paciente_id','fecha','descripcion'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
