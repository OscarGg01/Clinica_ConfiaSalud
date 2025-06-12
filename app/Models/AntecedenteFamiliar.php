<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteFamiliar extends Model
{

    protected $table = 'antecedentes_familiares';

    protected $fillable = ['paciente_id', 'texto'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
