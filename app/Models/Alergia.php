<?php

// app/Models/Alergia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $fillable = ['paciente_id','descripcion'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
