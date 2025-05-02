<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios'; // Nombre de la tabla en la BD
    protected $fillable = ['especialista_id', 'fecha', 'hora'];

    public function citas()
{
    return $this->hasMany(Cita::class, 'horario_id');
}
}