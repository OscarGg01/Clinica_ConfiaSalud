<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialista extends Model
{
    protected $fillable = ['area_id','nombre'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
