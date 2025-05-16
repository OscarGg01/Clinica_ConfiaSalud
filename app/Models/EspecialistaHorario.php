<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspecialistaHorario extends Model
{
    protected $fillable = ['especialista_id','hora'];

    public function especialista()
    {
        return $this->belongsTo(Especialista::class);
    }
}
